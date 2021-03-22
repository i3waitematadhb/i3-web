<?php

namespace {

    use SilverStripe\Control\Controller;

    class RelatedProjects extends Section
    {
        private static $singular_name = 'Related Projects';

        public function getAllRelatedProjects()
        {
            $controller = Controller::curr();
            return $controller->RelatedProjects();
        }
    }
}
