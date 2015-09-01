<?php
if ($page) {
    switch ($page) {
        case 'communities':
            if ($arg1) {
                $community = new Community();
                $community->getByPortalName($arg1);
                switch ($arg2) {
                    case 'insert':
                        include 'profile/shared-pages/component-pages/dynamic-data-add.php';
                        break;
                    case 'update':
                        include 'profile/shared-pages/component-pages/dynamic-data-update.php';
                        break;
                    case 'dynamic':
                        include 'profile/shared-pages/component-pages/dynamic-data.php';
                        break;
                    case 'type':
                        switch ($arg3) {
                            case 'add':
                                $type = new Resource_Type();
                                $type->getByID($arg4);
                                include 'profile/shared-pages/resource-pages/type-add.php';
                                break;
                            case 'edit':
                                $type = new Resource_Type();
                                $type->getByID($arg4);
                                include 'profile/shared-pages/resource-pages/type-edit.php';
                        }
                        break;
                    case 'component':
                        if ($arg3 == 'insert') {
                            $arg3 = $arg4;
                            include 'profile/shared-pages/component-pages/component-insert.php';
                        } elseif ($arg3 == 'update') {
                            $arg3 = $arg4;
                            include 'profile/shared-pages/component-pages/component-update.php';
                        } elseif ($arg3 == 'files') {
                            $arg3 = $arg4;
                            include 'profile/shared-pages/component-pages/component-files.php';
                        }
                        break;
                    case 'form':
                        $type = new Resource_Type();
                        $type->getByID($arg4);
                        include 'profile/shared-pages/resource-pages/form-edit.php';
                        break;
                    case 'components':
                        if ($arg3)
                            include 'profile/shared-pages/component-pages/components-' . $arg3 . '.php';
                        else
                            include 'profile/shared-pages/component-pages/components-page.php';
                        break;
                    case 'edit':
                        include 'profile/communities/community-update.php';
                        break;
                    case 'sources':
                        include 'profile/communities/community-sources.php';
                        break;
                    case 'view':
                        include 'profile/shared-pages/component-pages/data-view.php';
                        break;
                    default:
                        include 'profile/communities/community-single-page.php';
                }
            } else
                include 'profile/communities/community-page.php';
            break;
        case 'resources':
            if ($arg1) {
                if ($arg1 == 'edit')
                    include 'profile/resources/resource-edit.php';
            } else
                include 'profile/resources/resources.php';
            break;
        case 'scicrunch':
            $community = new Community();
            $community->id = 0;
            $community->name = 'SciCrunch';
            $community->portalName = 'scicrunch';
            if ($arg1) {
                switch ($arg1) {
                    case 'users':
                        include 'profile/scicrunch/users.php';
                        break;
                    case 'sources':
                        include 'profile/scicrunch/updateSources.php';
                        break;
                    case 'add':
                        include 'profile/scicrunch/add.php';
                        break;
                    case 'edit';
                        include 'profile/scicrunch/edit.php';
                        break;
                    case 'component':
                        if ($arg2 == 'insert') {
                            include 'profile/shared-pages/component-pages/component-insert.php';
                        } elseif ($arg2 == 'update') {
                            include 'profile/shared-pages/component-pages/component-update.php';
                        } elseif ($arg2 == 'files') {
                            include 'profile/shared-pages/component-pages/component-files.php';
                        }
                        break;
                    case 'type':
                        $type = new Resource_Type();
                        $type->getByID($arg3);
                        if ($arg2 == 'edit')
                            include 'profile/shared-pages/resource-pages/type-edit.php';
                        elseif ($arg2 == 'add')
                            include 'profile/shared-pages/resource-pages/type-add.php';
                        break;
                    case 'form':
                        if ($arg2 == 'edit')
                            include 'profile/shared-pages/resource-pages/form-edit.php';
                        break;
                    case 'components':
                        if ($arg2)
                            include 'profile/shared-pages/component-pages/components-' . $arg2 . '.php';
                        else
                            include 'profile/shared-pages/component-pages/components-page.php';
                        break;
                    case 'dynamic':
                        $arg3 = $arg2;
                        include 'profile/shared-pages/component-pages/dynamic-data.php';
                        break;
                    case 'view':
                        $arg3 = $arg2;
                        include 'profile/shared-pages/component-pages/data-view.php';
                        break;
                }
            } else
                include 'profile/scicrunch/home.php';
            break;
        case "saved":
            include 'profile/other-pages/save-search-overview.php';
    }
} else
    include 'profile/home.php';
?>