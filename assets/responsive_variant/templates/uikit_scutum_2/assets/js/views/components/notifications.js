/*
*  Scutum Admin_template
*  @version v1.0.1
*  @author tzd
*  @license http://themeforest.net/licenses

*  used in: components-notifications.html
*/

scutum.components = {};
scutum.components.notifications = {
	'init': function () {
		$('.sc-js-notify-default').on('click', function () {
			UIkit.notification('My message');
		});
		$('.sc-js-notify-persistent').on('click', function () {
			UIkit.notification('My persistent message', {
				timeout: false
			});
		});
		$('.sc-js-notify-icon').on('click', function () {
			UIkit.notification('<div class="uk-flex uk-flex-middle"><i class="mdi mdi-check-all uk-margin-right md-color-light-green-400"></i>Message</div>');
		});
		$('.sc-js-notify-long').on('click', function () {
			UIkit.notification('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, labore laudantium eaque obcaecati');
		});
		$('.sc-js-notify-link').on('click', function () {
			UIkit.notification('<div class="uk-flex uk-flex-middle"><span class="uk-flex-1">Message deleted!</span><a href="#" class="md-color-amber-500 uk-margin-small-left">undo</a></div>');
		});
		// positions
		$('.sc-js-notify-pos-top-left').on('click', function () {
			UIkit.notification('My message', {
				pos: 'top-left',
				timeout: false
			});
		});
		$('.sc-js-notify-pos-top-center').on('click', function () {
			UIkit.notification('My message', {
				pos: 'top-center'
			});
		});
		$('.sc-js-notify-pos-top-right').on('click', function () {
			UIkit.notification('My message', {
				pos: 'top-right'
			});
		});
		$('.sc-js-notify-pos-bottom-left').on('click', function () {
			UIkit.notification('My message', {
				pos: 'bottom-left'
			});
		});
		$('.sc-js-notify-pos-bottom-center').on('click', function () {
			UIkit.notification('My message', {
				pos: 'bottom-center'
			});
		});
		$('.sc-js-notify-pos-bottom-right').on('click', function () {
			UIkit.notification('My message', {
				pos: 'bottom-right'
			});
		});
		// status
		$('.sc-js-notify-status-primary').on('click', function () {
			UIkit.notification('My message', {
				status: 'primary'
			});
		});
		$('.sc-js-notify-status-success').on('click', function () {
			UIkit.notification('My message', {
				status: 'success'
			});
		});
		$('.sc-js-notify-status-danger').on('click', function () {
			UIkit.notification('My message', {
				status: 'danger'
			});
		});
		$('.sc-js-notify-status-warning').on('click', function () {
			UIkit.notification('My message', {
				status: 'warning'
			});
		});
	}
};
