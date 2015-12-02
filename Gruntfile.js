module.exports = function(grunt) {

	  grunt.initConfig({
		sprite:{
		  all: {
			src: 'wp-content/themes/interavtomatika/images/sprites/*.png',
			dest: 'wp-content/themes/interavtomatika/images/spritesheet.png',
			destCss: 'wp-content/themes/interavtomatika/css-source/sprites.css'
		  }
		},

	    // uglifycss: {
		  // my_target: {
		    // files: {
		 	 // '/minified.js': ['src/jquery.js', 'src/angular.js']
		    // }
		  // }
	    // },		
		
		// cssmin: {
		  // target: {
			// files: [{
			  // expand: true,
			  // cwd: 'wp-content/themes/interavtomatika/css-source/',
			  // src: ['styles.concat.css', '!*.min.css'],
			  // dest: 'wp-content/themes/interavtomatika/css/',
			  // ext: '.concat.min.css'
			// }]
		  // }
		// },
		
		concat_css: {
			options: {

			},   
			all: {
			  src: [
					"wp-content/themes/interavtomatika/css-source/general.css",
					"wp-content/themes/interavtomatika/css-source/header.css",
					"wp-content/themes/interavtomatika/css-source/aside.css",
					"wp-content/themes/interavtomatika/css-source/content.css",
					"wp-content/themes/interavtomatika/css-source/footer.css",
					"wp-content/themes/interavtomatika/css-source/modal-windows.css",
					"wp-content/themes/interavtomatika/css-source/brands.css",
					"wp-content/themes/interavtomatika/css-source/search.css",
					"wp-content/themes/interavtomatika/css-source/blog.css",
					"wp-content/themes/interavtomatika/css-source/catalog.css",
					"wp-content/themes/interavtomatika/css-source/products.css",
					"wp-content/themes/interavtomatika/css-source/product.css",
					"wp-content/themes/interavtomatika/css-source/cart.css",
					"wp-content/themes/interavtomatika/css-source/general-media.css",
					"wp-content/themes/interavtomatika/css-source/footer-media.css",
					"wp-content/themes/interavtomatika/css-source/content-media.css",
					"wp-content/themes/interavtomatika/css-source/aside-media.css",
					"wp-content/themes/interavtomatika/css-source/header-media.css",
					"wp-content/themes/interavtomatika/css-source/brands-media.css",
					"wp-content/themes/interavtomatika/css-source/search-media.css",
					"wp-content/themes/interavtomatika/css-source/blog-media.css",
					"wp-content/themes/interavtomatika/css-source/catalog-media.css",
					"wp-content/themes/interavtomatika/css-source/products-media.css",
					"wp-content/themes/interavtomatika/css-source/product-media.css",
					"wp-content/themes/interavtomatika/css-source/cart-media.css",
				],
			  dest: "wp-content/themes/interavtomatika/css/style.css"
			},
		  },
		
	  });
		
		
		grunt.loadNpmTasks('grunt-concat-css');
		
		grunt.loadNpmTasks('grunt-spritesmith');

		grunt.loadNpmTasks('grunt-contrib-cssmin');
		
		grunt.loadNpmTasks('grunt-contrib-uglify'); 
	
};