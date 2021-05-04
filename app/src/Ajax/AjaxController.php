<?php

namespace {

    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Control\HTTPRequest;
    use SilverStripe\SiteConfig\SiteConfig;
    use SilverStripe\View\Parsers\ShortcodeParser;

    class AjaxController extends AbstractApiController
    {
        private static $allowed_actions = [
            'getAllProjects',
            'getProjectsByFilter',
            'getAllQualityImprovementSessions',
            'getAllQualityImprovementSessionsByFilter',
            'getAllResources',
            'getFilteredResources',
            'findTagsParent'
        ];

        public function getAllProjects(HTTPRequest $request)
        {
            $output = [];
            $pageType = $request->postVar('type');

            $projectPages = '';

            if ($pageType == 'project') {
                $projectPages = ProjectPage::get();
            } else {
                $projectPages = QIProjectPage::get();
            }

            $config = SiteConfig::current_site_config();
            $configTitle = $config->Title;

            $placeholderImage = '_resources/themes/starter/images/PlaceholderImage.png';

            foreach ($projectPages as $page) {
                $projectPageCategories = $page->Categories();
                $page->FeaturedImage->URL ? $image = $page->FeaturedImage->URL : $image = $placeholderImage;
                $pageCategories = [];

                foreach ($projectPageCategories as $pageCategory) {
                    $pageCategories [] = $pageCategory->Title;
                }

                $output[] = [
                    'title' => $page->Title,
                    'year'  => $page->Year,
                    'link'  => $page->Link(),
                    'image' => $image,
                    'imageAlt'  => $page->Title . ' - ' . $configTitle,
                    'categories'=> $pageCategories
                ];
            }
            return $this->jsonOutput($output);
        }

        public function getProjectsByFilter(HTTPRequest $request)
        {
            $output = [];
            $config = SiteConfig::current_site_config();
            $configTitle = $config->Title;

            $selectedCategories = json_decode($request->postVar('categories'));
            $selectedYear       = $request->postVar('year');
            $pageType           = $request->postVar('type');

            $placeholderImage = '_resources/themes/starter/images/PlaceholderImage.png';

            if ($pageType == 'project') {
                $projectPages = ProjectPage::get();
            } else {
                $projectPages = QIProjectPage::get();
            }

            foreach ($projectPages as $page)
            {
                $projectPageCategories = $page->Categories();
                $page->FeaturedImage->URL ? $image = $page->FeaturedImage->URL : $image = $placeholderImage;
                $pageCategories = [];

                $imageAlt = $page->Title . ' - ' . $configTitle;

                foreach ($projectPageCategories as $category) {
                    $pageCategories [] = $category->Title;
                }

                if ($selectedYear !== 'All') {
                    if ($selectedYear === $page->Year) {
                        $result = $this->filterResult($selectedCategories, $pageCategories, $page, $image, $imageAlt);
                        if (count($result)) {
                            $output[] = $result;
                        }
                    }
                } else {
                    $result = $this->filterResult($selectedCategories, $pageCategories, $page, $image, $imageAlt);
                    if (count($result)) {
                        $output[] = $result;
                    }
                }
            }
            return $this->jsonOutput($output);
        }

        public function filterResult($selectedCategories, $pageCategories, $page, $image, $imageAlt)
        {
            $output = [];
            if (count($selectedCategories)) {
                if (count($pageCategories)) {
                    if (count(array_diff($selectedCategories, $pageCategories)) < 1) {
                        $output = [
                            'title' => $page->Title,
                            'year'  => $page->Year,
                            'link'  => $page->Link(),
                            'image' => $image,
                            'imageAlt'   => $imageAlt,
                            'categories' => $pageCategories
                        ];
                    }
                }
            } else {
                $output = [
                    'title' => $page->Title,
                    'year'  => $page->Year,
                    'link'  => $page->Link(),
                    'image' => $image,
                    'imageAlt'   => $imageAlt,
                    'categories' => $pageCategories
                ];
            }
            return $output;
        }

        public function getAllQualityImprovementSessions(HTTPRequest $request)
        {
            $output = [];
            $sessionPages = QISessionPage::get();

            $config = SiteConfig::current_site_config();
            $configTitle = $config->Title;

            $placeholderImage = '_resources/themes/starter/images/PlaceholderImage.png';

            foreach ($sessionPages as $page) {
                $sessionPageCategories = $page->Categories();
                $sessionPageAuthors    = $page->Authors();
                $page->FeaturedImage->URL ? $image = $page->FeaturedImage->URL : $image = $placeholderImage;
                $pageCategories = [];
                $pageAuthors    = [];

                foreach ($sessionPageCategories as $pageCategory) {
                    $pageCategories [] = $pageCategory->Name;
                }

                foreach ($sessionPageAuthors as $pageAuthor) {
                    $pageAuthors [] = $pageAuthor->Title;
                }

                $date = new DateTime($page->Date);
                $formattedDate = date_format($date, 'M d, Y');

                $output[] = [
                    'title' => $page->Title,
                    'date'  => $formattedDate,
                    'time'  => $page->Time,
                    'location' => $page->Location,
                    'summary'  => $page->ContentSummary,
                    'link'  => $page->Link(),
                    'image' => $image,
                    'imageAlt'  => $page->Title . ' - ' . $configTitle,
                    'authors'   => $pageAuthors,
                    'categories'=> $pageCategories
                ];
            }

            return $this->jsonOutput($output);
        }

        public function getAllResources(HTTPRequest $request)
        {
            $output = [];
            $parentID = $request->postVar('resourcesPageID');
            $resourcesPages = SiteTree::get()->filter('ParentID', $parentID);
            foreach ($resourcesPages as $page) {
                $resourcesPage = ResourcesPage::get()->byID($page->ID);
                $pageFilters = explode(',',$resourcesPage->Filters);
                $pageAuthors = explode(',',$page->Authors);
                $output[] = [
                    'title'   => $page->Title,
                    'categories' => $pageFilters,
                    'content' => ShortcodeParser::get_active()->parse($page->Content),
                    'authors' => $pageAuthors,
                    'abstract'=> ShortcodeParser::get_active()->parse($page->Abstract),
                    'image'   => $page->Image->URL
                ];
            }
            return $this->jsonOutput($output);
        }

        public function getFilteredResources(HTTPRequest $request)
        {
            $output = [];
            $selectedFilters = json_decode($request->postVar('filters'));
            $parentID = $request->postVar('resourcesPageID');

            $resourcesPages = SiteTree::get()->filter('ParentID', $parentID);
            foreach ($resourcesPages as $page) {
                $resourcesPage = ResourcesPage::get()->byID($page->ID);
                $pageFilters = explode(',',$resourcesPage->Filters);
                $pageAuthors = explode(',',$page->Authors);
                if (count(array_diff($selectedFilters, $pageFilters)) < 1) {
                    $output[] = [
                        'title'   => $page->Title,
                        'categories' => $pageFilters,
                        'content' => ShortcodeParser::get_active()->parse($page->Content),
                        'authors' => $pageAuthors,
                        'abstract'=> ShortcodeParser::get_active()->parse($page->Abstract),
                        'image'   => $page->Image->URL
                    ];
                }
            }
            return $this->jsonOutput($output);
        }

        public function findTagsParent(HTTPRequest $request)
        {
            $output = '';
            $tag = $request->postVar('tag');
            $resourcesPageID = $request->postVar('resourcesPageID');
            $filterItems = FilterItem::get()->filter('Name', $tag);
            foreach ($filterItems as $item) {
                $filter = Filter::get()->byID($item->ParentID);
                if ($filter->ParentID == $resourcesPageID) {
                    $output = [
                        'parentID' => $filter->ID,
                        'tagName'  => $tag
                    ];
                }
            }
            return $this->jsonOutput($output);
        }
    }
}
