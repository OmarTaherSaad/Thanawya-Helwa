$(document).ready( function () {
	$("table").DataTable({
		orderable: true,
		responsive: true,
		searching: false,
		paging: true,
		pagingType: "full_numbers",
		autoWidth: true,
		colReorder: true,
		scrollX: true,
		scrollY: true,
		scroller: {
			loadingIndicator: true
		},
		language: {
					"emptyTable":     "لا توجد بيانات في هذا الجدول",
					"info":           "إظهار بدايةً من _START_ إلى _END_ من أصل _TOTAL_ صفوف",
					"infoEmpty":      "إظهار 0 من 0 صفوف",
					"infoFiltered":   "(تمت التصفية من _MAX_ إجمالي الصفوف)",
					"infoPostFix":    "",
					"thousands":      ",",
					"lengthMenu":     "إظهار _MENU_ صفوف",
					"loadingRecords": "يتم التحميل...",
					"processing":     "تتم المعالجة...",
					"search":         "بحث:",
					"zeroRecords":    "لا توجد صفوف متوافقة مع البحث",
					"paginate": {
						"first":      "أول صفحة",
						"last":       "آخر صفحة",
						"next":       "الصفحة القادمة",
						"previous":   "الصفحة الماضية"
					}
				}

	}).adjust().draw();
});