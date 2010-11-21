li3_twig
========
Enables Twig support for Lithium PHP Framework.

Usage
-----
First enable the plugin with 

> Libraries::add('plugin', 'li3_twig', array(
>     'bootstrap' => true,
> ));

From your controller return arrays with properties that should be accessible in the Twig template.
Access your fields like this in the template later.
Note that the `this` is an automatically added reference to the Environment and under it you can lazy load
helpers like in regular lithium templates.

> <h1>Hello {{ name }}</h1>
> {{ this.form.create }}
> {{ this.form.text('title') }}
> {{ this.form.select('gender', ['m':'male','f':'female']) }}
> {{ this.form.end }}
