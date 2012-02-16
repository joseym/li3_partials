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

There have been a number of times I was working on a project and had a clean layout rendered but the client required that something in the layout change based on what view was rendered. I used elements and view `context` asignments for a while but that was neither elegant or enjoyable.

This is designed as a way to pass markup changes to section in a layout based on your view.

* #### In your view
wrap the markup you want passed to the layout in `<partial></partial>` tags with a `name` attribute.

	``` html
	<partial name="sidebar"><h2>Sidebar for this view!</h2></partial>
	```

* #### In your layout
There are 2 ways to print a blocked partial in your view

	1. Call the blocks partial name and assign type `block`

		``` php
		<?php echo $this->partial->sidebar(array('type' => 'block')); ?>
		```

	2. Call a partial block and pass the partials name
	
		```	php	
		<?php echo $this->partial->block('sidebar');?>
		```

Anywhere that you decide to place either of those will render the partial that was defined in your view at that location.

__Strings__

Similar to blocks, this method is used to pass strings of text to a layout. 

_"Why?" asks you, "Good question!" I reply_

Think in terms of a page description or keywords, these may need to change based on a page view but I could find no easy way to get these requirements to the layout.

* #### In your view
In the head of your view template (or anywhere, really, I just think it's cleaner to keep these together at the top) add:

	``` php
	<?php $this->partial->keywords('awesome, li3, github, php, partials, woot, nifty, grand, pie, unicorns, alfalfa sprouts'); ?>
	```
	It doesn't matter what you name this method, just keep in mind that that name will be how you call it in the layout.

* #### In your layout
Ok, so we defined keywords for our view! lets add them to the meta tag

	``` html
	<meta name="keywords" content="<?php echo $this->partial->keywords(); ?>" />
	```
	The plugin will find the stored keywords partial and render its contents where it was called.

There is also a wrapper to ensure you only pull strings - much like blocks

``` php
<?php echo $this->partial->string('keyword'); ?>
```

"That's foolish, it's easier just to use the other method!" you exclaim.
Hold tight, Fredword! I'll explain why you might want to do this below.

## Sharing Names

There may be a case where you define both a partial string and partial block with the same name.
To ensure that you pull the right one thee are 2 methods for each (actually 3 for .

__Strings__

```php
<?php echo $this->partial->string('methodName'); ?>
<?php echo $this->partial->methodName(array('type' => 'string')); ?>
```

__Blocks__

```php
<?php echo $this->partial->block('methodName'); ?>
<?php echo $this->partial->methodName(array('type' => 'block')); ?>
```

# To come
1. I plan on adding enhanced cache features to this so the rendering engine isn't constantly parsing templates for partials
2. Dynamic partials - support for a data schema to auto load partials from a database.
3. Drink a beer. Why not?
```