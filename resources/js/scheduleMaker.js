/*$(document).ready(function() {
	$('select').prop('selectedIndex',0);
});
*/
var subjects;

function addFields(element) {
	if ($("#section option:selected").val() != 0 && $("#secLang option:selected").val() != 0) {
		var lessonSelects_Container = $(element).siblings(".subjectChecking");
		//Day name to be used as an identifing class
		var ID = lessonSelects_Container.attr("id");
		//Creating <Select> element
		lessonSelects_Container.append('<select class="'+ID+'Subjects form-control"><option selected disabled>اختار المادة</option></select>');
		//Iterating through subjects
		subjects.forEach(function(currentSubjectName,index){
			$('.'+ID+'Subjects').last().append("<option>"+currentSubjectName+"</option>");
		});	
	} else {
		
	}
}
$("select.parameters").change(function() {
	$("td ul").empty();
	if ($("#section option:selected").val() != 0 && $("#secLang option:selected").val() != 0) {
		var secLang_value	= $("#section option:selected").val();
		var secLang_html	= $("#secLang option:selected").html();
		if (secLang_value == 1) {
			//Oloom
			subjects = ["عربي","English",secLang_html,"فيزياء","كيمياء","أحياء","جيولوجيا"];
		} else if (secLang_value == 2) {
			//Adby
			subjects = ["عربي","English",secLang_html,"فلسفة ومنطق","علم نفس واجتماع","تاريخ","جغرافيا"];
		} else if (secLang_value == 3) {
			//Ryada
			subjects = ["عربي","English",secLang_html,"فيزياء","كيمياء","رياضة"];
		}		
		
		$(".subjectChecking").each(function(index1,LessonSelects_container){
				//Edit options only
				$(LessonSelects_container).find("select").each(function() {
					$(this).html("<option selected disabled>اختار المادة</option>");
					//Day name to be used as an identifing class
					var ID = $(LessonSelects_container).attr("id");
					('.'+ID+'Subjects').html("");
					//Iterating through subjects
					subjects.forEach(function(currentSubjectName,index){
						$('.'+ID+'Subjects').append("<option>"+currentSubjectName+"</option>");
					});
				});
		});
	}
});

function checkboxChanged(element) {
	var day = $(element).attr("id").substring(1,4);
	var dayId = "#"+day;
	var Subjects = "";
	$("#_"+day+" input:checked").each(function() {
		Subjects += " - "+$(this).siblings("label").html();
	});
	Subjects = Subjects.substring(3);
	$("tr:eq("+(($(dayId).index()+1 > 7) ? ($(dayId).index()-7) : ($(dayId).index()+1) )+") td:eq(1)").html(Subjects);
	$("tr:eq("+(($(dayId).index()+2 > 7) ? ($(dayId).index()+2 - 7) : ($(dayId).index()+2) )+") td:eq(2)").html(Subjects);
	$("tr:eq("+(($(dayId).index()+4 > 7) ? ($(dayId).index()+4 - 7) : ($(dayId).index()+4) )+") td:eq(3)").html(Subjects);
	$("tr:eq("+(($(dayId).index() == 0)  ? 7 : $(dayId).index() )+") td:eq(4)").html(Subjects);
	
};