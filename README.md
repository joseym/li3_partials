# Partial Template support for [li3](http://lithify.me)
Plugin to pass template sections from view to the layout.

## Installation
1. Clone/Download the plugin into your app's ``libraries`` directory.
2. Tell your app to load the plugin by adding the following to your app's ``config/bootstrap/libraries.php``:

        Libraries::add('li3_partials');

## Features
1. Assign strings or entire blocks of markup to a partial.

## Usage
__Blocks__

* #### In your view
wrap the markup you want passed to the layout in `<partial></partial>` tags with a `name` attribute.

		<partial name="sidebar"><h2>Sidebar for this view!</h2></partial>

* #### In your layout
There are 2 ways to print a blocked partial in your view

	1. Call the blocks partial name and assign type `block`

			<?php echo $this->partial->sidebar(array('type' => 'block')); ?>

	2. Call a partial block and pass the partials name
	
		```	php	
		<?php echo $this->partial->block('sidebar');?>
		```

Anywhere that you decide to place either of those will render the partial that was defined in your view.