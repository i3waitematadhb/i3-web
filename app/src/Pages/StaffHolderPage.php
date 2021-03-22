<?php

namespace {

    class StaffHolderPage extends Page
    {
        private static $icon_class = 'font-icon-torsos-all';

        private static $default_child = StaffPage::class;

        private static $allowed_children = [
            StaffPage::class
        ];
    }
}
