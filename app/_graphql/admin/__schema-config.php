<?php 
return array (
  'resolverStrategy' => 'SilverStripe\\GraphQL\\Schema\\Resolver\\DefaultResolverStrategy::getResolverMethod',
  'defaultResolver' => 'SilverStripe\\GraphQL\\Schema\\Resolver\\DefaultResolver::defaultFieldResolver',
  'modelCreators' => 
  array (
    0 => 'SilverStripe\\GraphQL\\Schema\\DataObject\\ModelCreator',
  ),
  'modelConfig' => 
  array (
    'DataObject' => 
    array (
      'type_formatter' => 'SilverStripe\\Core\\ClassInfo::shortName',
      'type_prefix' => '',
      'type_mapping' => 
      array (
      ),
      'plugins' => 
      array (
        'inheritance' => true,
        'inheritedPlugins' => 
        array (
          'after' => '*',
        ),
        'versioning' => true,
      ),
      'operations' => 
      array (
        'read' => 
        array (
          'class' => 'SilverStripe\\GraphQL\\Schema\\DataObject\\ReadCreator',
          'plugins' => 
          array (
            'paginateList' => true,
            'canView' => 
            array (
              'after' => '*',
            ),
            'readVersion' => 
            array (
              'before' => 'paginateList',
            ),
            'getByLink' => 
            array (
              'after' => 'filter',
            ),
            'filter' => 
            array (
              'before' => 'paginateList',
            ),
            'sort' => 
            array (
              'before' => 'paginateList',
            ),
          ),
        ),
        'readOne' => 
        array (
          'class' => 'SilverStripe\\GraphQL\\Schema\\DataObject\\ReadOneCreator',
          'plugins' => 
          array (
            'firstResult' => 
            array (
              'after' => '*',
            ),
            'canView' => 
            array (
              'after' => '*',
            ),
            'readVersion' => 
            array (
              'before' => 'firstResult',
            ),
            'filter' => true,
            'sort' => true,
          ),
        ),
        'delete' => 
        array (
          'class' => 'SilverStripe\\GraphQL\\Schema\\DataObject\\DeleteCreator',
          'plugins' => 
          array (
            'unpublishOnDelete' => true,
          ),
        ),
        'update' => 
        array (
          'class' => 'SilverStripe\\GraphQL\\Schema\\DataObject\\UpdateCreator',
        ),
        'create' => 
        array (
          'class' => 'SilverStripe\\GraphQL\\Schema\\DataObject\\CreateCreator',
        ),
        'copyToStage' => 
        array (
          'class' => 'SilverStripe\\Versioned\\GraphQL\\Operations\\CopyToStageCreator',
        ),
        'publish' => 
        array (
          'class' => 'SilverStripe\\Versioned\\GraphQL\\Operations\\PublishCreator',
        ),
        'unpublish' => 
        array (
          'class' => 'SilverStripe\\Versioned\\GraphQL\\Operations\\UnpublishCreator',
        ),
        'rollback' => 
        array (
          'class' => 'SilverStripe\\Versioned\\GraphQL\\Operations\\RollbackCreator',
        ),
      ),
      'nested_query_plugins' => 
      array (
        'paginateList' => true,
        'filter' => 
        array (
          'before' => 'paginateList',
        ),
        'sort' => 
        array (
          'before' => 'paginateList',
        ),
        'canView' => 
        array (
          'after' => 'paginateList',
        ),
      ),
    ),
  ),
  'resolvers' => 
  array (
    0 => 'SilverStripe\\AssetAdmin\\GraphQL\\Resolvers\\AssetAdminResolver',
    1 => 'SilverStripe\\AssetAdmin\\GraphQL\\Resolvers\\FileTypeResolver',
    2 => 'SilverStripe\\AssetAdmin\\GraphQL\\Resolvers\\FolderTypeResolver',
    3 => 'SilverStripe\\AssetAdmin\\GraphQL\\Resolvers\\PublicationResolver',
    4 => 'SilverStripe\\CMS\\GraphQL\\Resolver',
  ),
  'execute' => 
  array (
    0 => 'SilverStripe\\AssetAdmin\\GraphQL\\Schema\\Builder',
  ),
  'typeMapping' => 
  array (
    'Page' => 'Page',
    'SilverStripe\\Security\\Member' => 'Member',
    'CareersHolderPage' => 'CareersHolderPage',
    'CareersPage' => 'CareersPage',
    'HomePage' => 'HomePage',
    'ProjectHolderPage' => 'ProjectHolderPage',
    'ProjectPage' => 'ProjectPage',
    'QIProjectHolderPage' => 'QIProjectHolderPage',
    'QIProjectPage' => 'QIProjectPage',
    'QISessionHolderPage' => 'QISessionHolderPage',
    'QISessionPage' => 'QISessionPage',
    'QualityImprovementPage' => 'QualityImprovementPage',
    'ResourcesHolderPage' => 'ResourcesHolderPage',
    'ResourcesPage' => 'ResourcesPage',
    'StaffHolderPage' => 'StaffHolderPage',
    'StaffPage' => 'StaffPage',
    'SilverStripe\\ErrorPage\\ErrorPage' => 'ErrorPage',
    'CWP\\CWP\\PageTypes\\BaseHomePage' => 'BaseHomePage',
    'CWP\\CWP\\PageTypes\\DatedUpdateHolder' => 'DatedUpdateHolder',
    'CWP\\CWP\\PageTypes\\EventHolder' => 'EventHolder',
    'CWP\\CWP\\PageTypes\\NewsHolder' => 'NewsHolder',
    'CWP\\CWP\\PageTypes\\DatedUpdatePage' => 'DatedUpdatePage',
    'CWP\\CWP\\PageTypes\\EventPage' => 'EventPage',
    'CWP\\CWP\\PageTypes\\NewsPage' => 'NewsPage',
    'CWP\\CWP\\PageTypes\\SitemapPage' => 'SitemapPage',
    'SilverStripe\\CMS\\Model\\RedirectorPage' => 'RedirectorPage',
    'CWP\\CWP\\PageTypes\\FooterHolder' => 'FooterHolder',
    'SilverStripe\\CMS\\Model\\VirtualPage' => 'VirtualPage',
  ),
  'fieldMapping' => 
  array (
    'Page' => 
    array (
      'id' => 
      array (
        0 => 'Page',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'Page',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'Page',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'Page',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'Page',
        1 => 'versions',
      ),
    ),
    'Member' => 
    array (
      'id' => 
      array (
        0 => 'Member',
        1 => 'ID',
      ),
      'firstName' => 
      array (
        0 => 'Member',
        1 => 'FirstName',
      ),
      'surname' => 
      array (
        0 => 'Member',
        1 => 'Surname',
      ),
    ),
    'CareersHolderPage' => 
    array (
      'id' => 
      array (
        0 => 'CareersHolderPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'CareersHolderPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'CareersHolderPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'CareersHolderPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'CareersHolderPage',
        1 => 'versions',
      ),
    ),
    'CareersPage' => 
    array (
      'id' => 
      array (
        0 => 'CareersPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'CareersPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'CareersPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'CareersPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'CareersPage',
        1 => 'versions',
      ),
    ),
    'HomePage' => 
    array (
      'id' => 
      array (
        0 => 'HomePage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'HomePage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'HomePage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'HomePage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'HomePage',
        1 => 'versions',
      ),
    ),
    'ProjectHolderPage' => 
    array (
      'id' => 
      array (
        0 => 'ProjectHolderPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'ProjectHolderPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'ProjectHolderPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'ProjectHolderPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'ProjectHolderPage',
        1 => 'versions',
      ),
    ),
    'ProjectPage' => 
    array (
      'id' => 
      array (
        0 => 'ProjectPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'ProjectPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'ProjectPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'ProjectPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'ProjectPage',
        1 => 'versions',
      ),
    ),
    'QIProjectHolderPage' => 
    array (
      'id' => 
      array (
        0 => 'QIProjectHolderPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'QIProjectHolderPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'QIProjectHolderPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'QIProjectHolderPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'QIProjectHolderPage',
        1 => 'versions',
      ),
    ),
    'QIProjectPage' => 
    array (
      'id' => 
      array (
        0 => 'QIProjectPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'QIProjectPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'QIProjectPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'QIProjectPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'QIProjectPage',
        1 => 'versions',
      ),
    ),
    'QISessionHolderPage' => 
    array (
      'id' => 
      array (
        0 => 'QISessionHolderPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'QISessionHolderPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'QISessionHolderPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'QISessionHolderPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'QISessionHolderPage',
        1 => 'versions',
      ),
    ),
    'QISessionPage' => 
    array (
      'id' => 
      array (
        0 => 'QISessionPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'QISessionPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'QISessionPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'QISessionPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'QISessionPage',
        1 => 'versions',
      ),
    ),
    'QualityImprovementPage' => 
    array (
      'id' => 
      array (
        0 => 'QualityImprovementPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'QualityImprovementPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'QualityImprovementPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'QualityImprovementPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'QualityImprovementPage',
        1 => 'versions',
      ),
    ),
    'ResourcesHolderPage' => 
    array (
      'id' => 
      array (
        0 => 'ResourcesHolderPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'ResourcesHolderPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'ResourcesHolderPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'ResourcesHolderPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'ResourcesHolderPage',
        1 => 'versions',
      ),
    ),
    'ResourcesPage' => 
    array (
      'id' => 
      array (
        0 => 'ResourcesPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'ResourcesPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'ResourcesPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'ResourcesPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'ResourcesPage',
        1 => 'versions',
      ),
    ),
    'StaffHolderPage' => 
    array (
      'id' => 
      array (
        0 => 'StaffHolderPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'StaffHolderPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'StaffHolderPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'StaffHolderPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'StaffHolderPage',
        1 => 'versions',
      ),
    ),
    'StaffPage' => 
    array (
      'id' => 
      array (
        0 => 'StaffPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'StaffPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'StaffPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'StaffPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'StaffPage',
        1 => 'versions',
      ),
    ),
    'ErrorPage' => 
    array (
      'id' => 
      array (
        0 => 'ErrorPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'ErrorPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'ErrorPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'ErrorPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'ErrorPage',
        1 => 'versions',
      ),
    ),
    'BaseHomePage' => 
    array (
      'id' => 
      array (
        0 => 'BaseHomePage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'BaseHomePage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'BaseHomePage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'BaseHomePage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'BaseHomePage',
        1 => 'versions',
      ),
    ),
    'DatedUpdateHolder' => 
    array (
      'id' => 
      array (
        0 => 'DatedUpdateHolder',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'DatedUpdateHolder',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'DatedUpdateHolder',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'DatedUpdateHolder',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'DatedUpdateHolder',
        1 => 'versions',
      ),
    ),
    'EventHolder' => 
    array (
      'id' => 
      array (
        0 => 'EventHolder',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'EventHolder',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'EventHolder',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'EventHolder',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'EventHolder',
        1 => 'versions',
      ),
    ),
    'NewsHolder' => 
    array (
      'id' => 
      array (
        0 => 'NewsHolder',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'NewsHolder',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'NewsHolder',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'NewsHolder',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'NewsHolder',
        1 => 'versions',
      ),
    ),
    'DatedUpdatePage' => 
    array (
      'id' => 
      array (
        0 => 'DatedUpdatePage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'DatedUpdatePage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'DatedUpdatePage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'DatedUpdatePage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'DatedUpdatePage',
        1 => 'versions',
      ),
    ),
    'EventPage' => 
    array (
      'id' => 
      array (
        0 => 'EventPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'EventPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'EventPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'EventPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'EventPage',
        1 => 'versions',
      ),
    ),
    'NewsPage' => 
    array (
      'id' => 
      array (
        0 => 'NewsPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'NewsPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'NewsPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'NewsPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'NewsPage',
        1 => 'versions',
      ),
    ),
    'SitemapPage' => 
    array (
      'id' => 
      array (
        0 => 'SitemapPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'SitemapPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'SitemapPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'SitemapPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'SitemapPage',
        1 => 'versions',
      ),
    ),
    'RedirectorPage' => 
    array (
      'id' => 
      array (
        0 => 'RedirectorPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'RedirectorPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'RedirectorPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'RedirectorPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'RedirectorPage',
        1 => 'versions',
      ),
    ),
    'FooterHolder' => 
    array (
      'id' => 
      array (
        0 => 'FooterHolder',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'FooterHolder',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'FooterHolder',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'FooterHolder',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'FooterHolder',
        1 => 'versions',
      ),
    ),
    'VirtualPage' => 
    array (
      'id' => 
      array (
        0 => 'VirtualPage',
        1 => 'ID',
      ),
      'lastEdited' => 
      array (
        0 => 'VirtualPage',
        1 => 'LastEdited',
      ),
      'absoluteLink' => 
      array (
        0 => 'VirtualPage',
        1 => 'absoluteLink',
      ),
      'version' => 
      array (
        0 => 'VirtualPage',
        1 => 'Version',
      ),
      'versions' => 
      array (
        0 => 'VirtualPage',
        1 => 'versions',
      ),
    ),
  ),
);