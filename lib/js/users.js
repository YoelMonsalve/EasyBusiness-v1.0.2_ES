/** USERS_JS
 *  JavaScript background to the page 'users.php'
 *
 *  __________________________________
 *  (C) Yoel Monsalve, 2020-2021.
 */

$(document).ready(function() {
	$('#tbl-users').DataTable({
		"scrollY"       : "20em",
		"scrollCollapse": true,
		"paging"        : false
	})
})
