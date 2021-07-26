/** GROUPS_JS
 *  JavaScript background to the page 'groups.php'
 *
 *  __________________________________
 *  (C) Yoel Monsalve, 2020-2021.
 */

$(document).ready(function() {
	$('#tbl-groups').DataTable({
		"scrollY"       : "20em",
		"scrollCollapse": true,
		"paging"        : false
	})
})
