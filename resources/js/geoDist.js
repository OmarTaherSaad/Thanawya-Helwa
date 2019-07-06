function getAdmin(val) {
    axios.post('/Tansik/gov', {
            gov: val
        })
        .then(function (r) {
            if (r.data.admins === 0) {
                //No Admins
                makeDistTable(r.data.dist);

            } else {
                //Admins exist
                JSONresponse = JSON.parse(r.data);
                console.log(JSONresponse);
            }
        });
}

function getDist(val) {

}

function makeDistTable(DistArr) {
    /*Create The Table START*/
    let table = document.createElement('table');
    table.id = "DistTable";
    //iterate over every array(row) within Distribution Array
    for (let row of DistArr) {
        //Insert a new row element into the table element
        table.insertRow();
        //Iterate over every index(cell) in each array(row)
        for (let cell of row) {
            //While iterating over the index(cell)
            //insert a cell into the table element
            let newCell = table.rows[table.rows.length - 1].insertCell();
            //add text to the created cell element
            newCell.textContent = cell;
        }
    }
    /*Create The Table END*/
    
    //append the compiled table to the DOM
    document.getElementById('result').innerHTML = '';
    document.getElementById('result').appendChild(table);
    //Coloring it
    $("#DistTable").hide().css("background-color", "cornsilk").show(1000);
    //Instantiate Tabular for grouping
    
    // // code for grouping in "after" table
    // var $rows = $(table).find('tr');
    // var items = [],
    //     itemtext = [],
    //     currGroupStartIdx = 0;
    // $rows.each(function (i) {
    //     var $this = $(this);
    //     var itemCell = $(this).find('td:eq(0)');
    //     var item = itemCell.text();
    //     itemCell.remove();
    //     if ($.inArray(item, itemtext) === -1) {
    //         itemtext.push(item);
    //         items.push([i, item]);
    //         groupRowSpan = 1;
    //         currGroupStartIdx = i;
    //         $this.data('rowspan', 1);
    //     } else {
    //         var rowspan = $rows.eq(currGroupStartIdx).data('rowspan') + 1;
    //         $rows.eq(currGroupStartIdx).data('rowspan', rowspan);
    //     }

    // });



    // $.each(items, function (i) {
    //     var $row = $rows.eq(this[0]);
    //     var rowspan = $row.data('rowspan');
    //     $row.prepend('<td rowspan="' + rowspan + '">' + this[1] + '</td>');
    // });
    // //END
    // jQuery.each($("table tr"), function () {
    //     $(this).children(":eq(1)").after($(this).children(":eq(0)"));
    // });
    $('html, body').animate({
        scrollTop: $("#result table").offset().top
    }, 2000);
}