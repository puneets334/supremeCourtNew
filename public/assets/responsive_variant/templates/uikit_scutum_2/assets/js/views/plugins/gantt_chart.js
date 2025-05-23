/*
*  Scutum Admin_template
*  @version v1.0.1
*  @author tzd
*  @license http://themeforest.net/licenses

*  used in: plugins-gantt_chart.html
*/

scutum.plugins.ganttChart = {};
scutum.plugins.ganttChart.init = function () {
	scutum.require(['kinetic', 'jquery-ui', 'gantt-chart'], function () {
		var $gantt_chart = $('#sc-gantt-chart');
		if ($gantt_chart.length) {
			$gantt_chart.ganttView({
				data: scutum.plugins.ganttChart.ganttData,
				startDate: '07/29/2019',
				endDate: '11/30/2019',
				showToday: true, // highlight today
				// startToday: true, // scroll to today
				behavior: {
					onClick: function (data) {
						console.log("You clicked on an event: " + "\n", data);
					},
					onResize: function (data) {
						console.log('You resized an event: ' + "\n", data);
					},
					onDrag: function (data) {
						console.log("You dragged an event: " + "\n", data);
					}
				}
			});
			$gantt_chart.find('[title]').each(function () {
				$(this).attr('data-uk-tooltip', "{offset:4}");
			});
		}
	}, false);
};
scutum.plugins.ganttChart.ganttData = [
	{
		name: "Concept",
		series: [
			{
				name: "Brainstorm",
				sub_series: [
					{
						id: 1,
						start: '08/01/2019',
						end: '08/03/2019',
						color: "#00897B",
						title: 'Custom title',
						link: 'http://themeforest.com',
						user_name: "Bobbie Spinka",
						user_avatar: "assets/img/avatars/avatar_01_sm.png"
					},
					{
						id: 2,
						start: '08/05/2019',
						end: '08/08/2019',
						color: "#00897B"
					}
				]
			},
			{
				name: "Wireframes",
				sub_series: [
					{
						id: 3,
						start: '08/04/2019',
						end: '08/07/2019',
						color: "#00796B",
						title: 'lorem ipsum dolor',
						user_name: "Khalid Leffler",
						user_avatar: "assets/img/avatars/avatar_03_sm.png"
					},
					{
						id: 4,
						start: '08/10/2019',
						end: '08/14/2019',
						color: "#00796B"
					},
					{
						id: 5,
						start: '08/18/2019',
						end: '08/26/2019',
						color: "#00695C",
						user_name: "Dexter Schaden",
						user_avatar: "assets/img/avatars/avatar_06_sm.png"
					}
				]
			},
			{
				id: 6,
				name: "Concept description",
				start: '08/06/2019',
				end: '08/10/2019',
				color: "#004D40"
			}
		]
	},
	{
		name: "Design",
		series: [
			{
				id: 7,
				name: "Sketching",
				start: '08/08/2019',
				end: '08/16/2019',
				color: "#9C27B0"
			},
			{
				id: 8,
				name: "Photography",
				start: '08/10/2019',
				end: '08/16/2019',
				color: "#8E24AA",
				title: 'Some inspirations',
				link: 'https://unsplash.com/',
				user_name: "Deion Stroman",
				user_avatar: "assets/img/avatars/avatar_05_sm.png"
			},
			{
				name: "Feedback",
				sub_series: [
					{
						id: 9,
						start: '08/19/2019',
						end: '08/21/2019',
						color: "#7B1FA2"
					},
					{
						id: 10,
						start: '08/24/2019',
						end: '08/28/2019',
						color: "#7B1FA2"
					}
				]

			},
			{
				id: 11,
				name: "Final Design",
				start: '08/21/2019',
				end: '08/29/2019',
				color: "#6A1B9A",
				user_name: "Jany Zulauf",
				user_avatar: "assets/img/avatars/avatar_02_sm.png"
			}
		]
	},
	{
		name: "Implementation",
		series: [
			{
				id: 12,
				name: "Specifications",
				start: '08/26/2019',
				end: '09/06/2019',
				color: "#8BC34A"
			},
			{
				id: 13,
				name: "Templates",
				start: '09/04/2019',
				end: '09/10/2019',
				color: "#7CB342"
			},
			{
				id: 14,
				name: "Database",
				start: '09/05/2019',
				end: '09/13/2019',
				color: "#689F38"
			},
			{
				id: 15,
				name: "Integration",
				start: '09/16/2019',
				end: '10/10/2019',
				color: "#558B2F",
				user_name: "Orville Bogisich",
				user_avatar: "assets/img/avatars/avatar_07_sm.png"
			}
		]
	},
	{
		name: "Testing & Delivery",
		series: [
			{
				id: 16,
				name: "Focus Group",
				start: '10/17/2019',
				end: '10/27/2019',
				color: "#F57C00"
			},
			{
				name: "Stress Test",
				sub_series: [
					{
						id: 17,
						start: '10/25/2019',
						end: '11/06/2019',
						color: "#EF6C00"
					},
					{
						id: 18,
						start: '11/09/2019',
						end: '11/12/2019',
						color: "#EF6C00"
					}
				]
			},
			{
				id: 19,
				name: "Delivery",
				start: '11/07/2019',
				end: '11/12/2019',
				color: "#E65100",
				user_name: "Yoshiko Shanahan",
				user_avatar: "assets/img/avatars/avatar_06_sm.png"
			}
		]
	}
];
