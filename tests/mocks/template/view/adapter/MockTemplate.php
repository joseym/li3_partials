<?php

namespace li3_twig\tests\mocks\template\view\adapter;

class MockTemplate extends \li3_twig\template\view\adapter\Template {
    public function display(array $context, array $blocks = array()) {
        echo $this->getAttribute((isset($context['foo']) ? $context['foo'] : null), "bar", array(), "any");
    }

    public function getTemplateName() {
        return "mock.html.twig";
    }
}

