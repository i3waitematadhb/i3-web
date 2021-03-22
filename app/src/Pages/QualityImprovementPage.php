<?php

namespace {

    class QualityImprovementPage extends Page
    {
        private static $icon_class = 'font-icon-rocket';

        private static $allowed_children = [
            QISessionHolderPage::class,
            QIProjectHolderPage::class
        ];
    }
}
