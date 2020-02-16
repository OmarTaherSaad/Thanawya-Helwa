import { loadProgressBar } from 'axios-progress-bar';

loadProgressBar();

(function () {
    var filesUpload = document.getElementById("memberImage"),
        dropArea = document.getElementById("drop-area"),
        fileList = document.getElementById("file-list");

    function uploadFile(file) {
        if (typeof FileReader == "undefined" || !(/image/i).test(file.type))
        {
            alert("Please, choose an image.");
            return;
        }
        var li = document.createElement("li"),
            div = document.createElement("div"),
            img,
            reader,
            fileInfo;

        li.appendChild(div);
        img = document.createElement("img");
        img.classList.add('img-fluid');
        li.appendChild(img);
        reader = new FileReader();
        reader.onload = (function (theImg) {
            return function (evt) {
                theImg.src = evt.target.result;
            };
        }(img));
        reader.readAsDataURL(file);


        // Present file info and append it to the list of files
        fileInfo = "<div><strong>Name:</strong> " + file.name + "</div>";
        fileInfo += "<div><strong>Size:</strong> " + parseInt(file.size / 1024, 10) + " kb</div>";
        fileInfo += "<div><strong>Type:</strong> " + file.type + "</div>";
        div.innerHTML = fileInfo;
        fileList.innerHTML = '';
        fileList.appendChild(li);
    }

    function traverseFiles(files) {
        if (files.length < 1)
        {
            fileList.innerHTML = '';
        }
        if (typeof files !== "undefined") {
            for (var i = 0, l = files.length; i < l; i++) {
                uploadFile(files[i]);
            }
        } else {
            fileList.innerHTML = "No support for the File API in this web browser";
        }
    }

    filesUpload.addEventListener("change", function () {
        traverseFiles(this.files);
    }, false);

    dropArea.addEventListener("dragleave", function (evt) {
        var target = evt.target;

        if (target && target === dropArea) {
            this.className = "";
        }
        evt.preventDefault();
        evt.stopPropagation();
    }, false);

    dropArea.addEventListener("dragenter", function (evt) {
        this.className = "over";
        evt.preventDefault();
        evt.stopPropagation();
    }, false);

    dropArea.addEventListener("dragover", function (evt) {
        evt.preventDefault();
        evt.stopPropagation();
    }, false);

    dropArea.addEventListener("drop", function (evt) {
        traverseFiles(evt.dataTransfer.files);
        this.className = "";
        evt.preventDefault();
        evt.stopPropagation();
    }, false);
})();
