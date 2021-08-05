<?php

 /** GENERATED CODE -- DO NOT MODIFY **/

namespace SSGraphQLSchema_21232f297a57a5a743894a0e4a801fc3;
use SilverStripe\GraphQL\Schema\Storage\AbstractTypeRegistry;
class Types extends AbstractTypeRegistry
{
    protected static $types = [];
    protected static function getSourceDirectory(): string
    {
        return __DIR__;
    }
    protected static function getSourceNamespace(): string
    {
        return __NAMESPACE__;
    }
    public static function DBFile() { return static::get('DBFile'); }
    public static function CopyToStageInputType() { return static::get('CopyToStageInputType'); }
    public static function VersionedInputType() { return static::get('VersionedInputType'); }
    public static function File() { return static::get('File'); }
    public static function FileFilterInput() { return static::get('FileFilterInput'); }
    public static function FileInput() { return static::get('FileInput'); }
    public static function FileUsage() { return static::get('FileUsage'); }
    public static function Folder() { return static::get('Folder'); }
    public static function FolderInput() { return static::get('FolderInput'); }
    public static function PublicationNotice() { return static::get('PublicationNotice'); }
    public static function PageInfo() { return static::get('PageInfo'); }
    public static function QueryFilterStringComparator() { return static::get('QueryFilterStringComparator'); }
    public static function QueryFilterBooleanComparator() { return static::get('QueryFilterBooleanComparator'); }
    public static function QueryFilterIntComparator() { return static::get('QueryFilterIntComparator'); }
    public static function QueryFilterFloatComparator() { return static::get('QueryFilterFloatComparator'); }
    public static function QueryFilterIDComparator() { return static::get('QueryFilterIDComparator'); }
    public static function PageVersion() { return static::get('PageVersion'); }
    public static function VersionsSimpleSortFields() { return static::get('VersionsSimpleSortFields'); }
    public static function VersionsConnectionEdge() { return static::get('VersionsConnectionEdge'); }
    public static function VersionsConnection() { return static::get('VersionsConnection'); }
    public static function CareersHolderPageVersion() { return static::get('CareersHolderPageVersion'); }
    public static function CareersPageVersion() { return static::get('CareersPageVersion'); }
    public static function HomePageVersion() { return static::get('HomePageVersion'); }
    public static function ProjectHolderPageVersion() { return static::get('ProjectHolderPageVersion'); }
    public static function ProjectPageVersion() { return static::get('ProjectPageVersion'); }
    public static function QIProjectHolderPageVersion() { return static::get('QIProjectHolderPageVersion'); }
    public static function QIProjectPageVersion() { return static::get('QIProjectPageVersion'); }
    public static function QISessionHolderPageVersion() { return static::get('QISessionHolderPageVersion'); }
    public static function QISessionPageVersion() { return static::get('QISessionPageVersion'); }
    public static function QualityImprovementPageVersion() { return static::get('QualityImprovementPageVersion'); }
    public static function ResourcesHolderPageVersion() { return static::get('ResourcesHolderPageVersion'); }
    public static function ResourcesPageVersion() { return static::get('ResourcesPageVersion'); }
    public static function StaffHolderPageVersion() { return static::get('StaffHolderPageVersion'); }
    public static function StaffPageVersion() { return static::get('StaffPageVersion'); }
    public static function ErrorPageVersion() { return static::get('ErrorPageVersion'); }
    public static function BaseHomePageVersion() { return static::get('BaseHomePageVersion'); }
    public static function DatedUpdateHolderVersion() { return static::get('DatedUpdateHolderVersion'); }
    public static function EventHolderVersion() { return static::get('EventHolderVersion'); }
    public static function NewsHolderVersion() { return static::get('NewsHolderVersion'); }
    public static function DatedUpdatePageVersion() { return static::get('DatedUpdatePageVersion'); }
    public static function EventPageVersion() { return static::get('EventPageVersion'); }
    public static function NewsPageVersion() { return static::get('NewsPageVersion'); }
    public static function SitemapPageVersion() { return static::get('SitemapPageVersion'); }
    public static function RedirectorPageVersion() { return static::get('RedirectorPageVersion'); }
    public static function FooterHolderVersion() { return static::get('FooterHolderVersion'); }
    public static function VirtualPageVersion() { return static::get('VirtualPageVersion'); }
    public static function PageFilterFields() { return static::get('PageFilterFields'); }
    public static function PageSortFields() { return static::get('PageSortFields'); }
    public static function MemberFilterFields() { return static::get('MemberFilterFields'); }
    public static function MemberSortFields() { return static::get('MemberSortFields'); }
    public static function FolderChildrenSortFields() { return static::get('FolderChildrenSortFields'); }
    public static function ChildrenConnectionEdge() { return static::get('ChildrenConnectionEdge'); }
    public static function ChildrenConnection() { return static::get('ChildrenConnection'); }
    public static function Page() { return static::get('Page'); }
    public static function Member() { return static::get('Member'); }
    public static function CareersHolderPage() { return static::get('CareersHolderPage'); }
    public static function CareersPage() { return static::get('CareersPage'); }
    public static function HomePage() { return static::get('HomePage'); }
    public static function ProjectHolderPage() { return static::get('ProjectHolderPage'); }
    public static function ProjectPage() { return static::get('ProjectPage'); }
    public static function QIProjectHolderPage() { return static::get('QIProjectHolderPage'); }
    public static function QIProjectPage() { return static::get('QIProjectPage'); }
    public static function QISessionHolderPage() { return static::get('QISessionHolderPage'); }
    public static function QISessionPage() { return static::get('QISessionPage'); }
    public static function QualityImprovementPage() { return static::get('QualityImprovementPage'); }
    public static function ResourcesHolderPage() { return static::get('ResourcesHolderPage'); }
    public static function ResourcesPage() { return static::get('ResourcesPage'); }
    public static function StaffHolderPage() { return static::get('StaffHolderPage'); }
    public static function StaffPage() { return static::get('StaffPage'); }
    public static function ErrorPage() { return static::get('ErrorPage'); }
    public static function BaseHomePage() { return static::get('BaseHomePage'); }
    public static function DatedUpdateHolder() { return static::get('DatedUpdateHolder'); }
    public static function EventHolder() { return static::get('EventHolder'); }
    public static function NewsHolder() { return static::get('NewsHolder'); }
    public static function DatedUpdatePage() { return static::get('DatedUpdatePage'); }
    public static function EventPage() { return static::get('EventPage'); }
    public static function NewsPage() { return static::get('NewsPage'); }
    public static function SitemapPage() { return static::get('SitemapPage'); }
    public static function RedirectorPage() { return static::get('RedirectorPage'); }
    public static function FooterHolder() { return static::get('FooterHolder'); }
    public static function VirtualPage() { return static::get('VirtualPage'); }
    public static function Query() { return static::get('Query'); }
    public static function Mutation() { return static::get('Mutation'); }
    public static function VersionedStage() { return static::get('VersionedStage'); }
    public static function VersionedQueryMode() { return static::get('VersionedQueryMode'); }
    public static function VersionedStatus() { return static::get('VersionedStatus'); }
    public static function AppCategory() { return static::get('AppCategory'); }
    public static function SortDirection() { return static::get('SortDirection'); }
    public static function FileInterface() { return static::get('FileInterface'); }
    public static function PublicationResult() { return static::get('PublicationResult'); }
    public static function FileResult() { return static::get('FileResult'); }
}
