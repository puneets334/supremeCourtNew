/*
*  Scutum Admin_template
*  @version v1.0.1
*  @author tzd
*  @license http://themeforest.net/licenses

*  used in: plugins-push_notifications.html
*/

scutum.plugins.pushNotifications = {};
scutum.plugins.pushNotifications.init = function () {
	scutum.require(['pushJS'], function () {
		$('#sc-js-push-send').on('click', function () {
			Push.create("Hello from Scutum template.", {
				body: "How's it hangin'?",
				icon: 'assets/img/avatars/avatar_05_md@2x.png',
				timeout: 8000,
				onClick: function () {
					window.focus();
					this.close();
				}
			});
		})
	});
};
