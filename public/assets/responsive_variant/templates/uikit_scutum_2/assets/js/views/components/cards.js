/*
*  Scutum Admin_template
*  @version v1.0.1
*  @author tzd
*  @license http://themeforest.net/licenses

*  used in: components-cards.html
*/

scutum.components.cards = {};
scutum.components.cards.init = function () {
	var replaceContent = function () {
		var yourString = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus adipisci autem, consequatur dolore dolorum error expedita fugiat illo magnam, nisi nulla omnis quibusdam, voluptates. Aspernatur nam necessitatibus quo ratione vel? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad amet aperiam, aut delectus dolorum, ducimus expedita fugit hic impedit, molestiae nesciunt odio officiis quam quisquam repellat unde voluptas! Assumenda ducimus eius exercitationem illum, incidunt ipsum laborum nesciunt quia sit tempore temporibus unde veritatis voluptates. Assumenda dicta enim qui quibusdam quisquam repellendus vel voluptate! Aliquam doloremque eum obcaecati quod! Ab dicta dolor enim, fuga inventore labore nobis numquam placeat quibusdam recusandae repellat repudiandae sed tempore? Aperiam cumque, excepturi expedita nemo nihil quis repudiandae! Alias aspernatur autem blanditiis cupiditate delectus dignissimos dolor dolore eaque est et harum, incidunt laborum magni omnis provident quibusdam quis quo ratione tempora temporibus ut vitae voluptatibus voluptatum. Assumenda aut deserunt eum minima mollitia praesentium provident quisquam tempore ut, voluptas. Amet dicta dolorem earum, eum exercitationem expedita in ipsam iusto molestias natus nostrum odit pariatur possimus quam quibusdam unde voluptate. Alias aliquid at culpa, cumque dicta, eveniet harum ipsum labore nisi odit possimus reiciendis sapiente suscipit? Aspernatur beatae blanditiis commodi consequuntur dignissimos explicabo impedit incidunt itaque laudantium quaerat quisquam tempora, vitae voluptates. Ad amet architecto at consequatur deserunt dignissimos dolorem dolorum est facere fuga fugit, hic illum incidunt inventore magni perspiciatis praesentium repellat, sed suscipit tempora? Cum cupiditate ducimus esse id minus nulla voluptate? Ad autem cum cumque cupiditate dolorem eaque error illum neque quisquam unde! Dolor eius eligendi mollitia nesciunt obcaecati perferendis placeat quos reprehenderit saepe sapiente sunt, vitae voluptates! Ad aliquid animi aspernatur atque commodi corporis cumque cupiditate distinctio eveniet excepturi facere in, itaque libero minus praesentium quas quidem ratione recusandae repellat tempore totam voluptate voluptatem voluptatibus? A assumenda aut consequatur dicta distinctio eius enim eum, exercitationem harum ipsum iure libero maxime molestias nesciunt nostrum obcaecati pariatur possimus praesentium, qui quibusdam quisquam quod quos repellendus tempore vel velit vero voluptates. Adipisci architecto id laudantium non optio provident reiciendis rem sapiente! A accusamus aperiam aspernatur beatae culpa cupiditate deserunt distinctio eum hic illum, libero modi necessitatibus optio sint veritatis. Aliquid atque consequuntur deleniti, earum facere illo iste molestiae necessitatibus nulla quibusdam quod repudiandae veniam voluptatem.";
		var trimmedString = yourString.substr(0, Math.floor((Math.random() * 2881) + 100));
		trimmedString = trimmedString.substr(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")));
		$('#sc-card-dynamic-content')
			.css({ 'opacity': 0 })
			.html('<strong>New content!</strong><br>' + trimmedString)
			.velocity("transition.slideUpIn");
	};
	$('.sc-js-card-reload').on('click', function () {
		var $this = $(this);
		var $card = $this.closest('.uk-card');
		if (!$card.hasClass('sc-card-minimized')) {
			scutum.cards.hideContent($this, true);
			setTimeout(function () {
				scutum.cards.showContent($this, true, replaceContent);
			}, 2000)
		}
	});
};
