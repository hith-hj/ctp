<?php

use Illuminate\Support\Facades\Auth;

/**
 * Aside menu
 *
 * @param  null  $parent
 * @param  int  $rec
 * @param  bool  $singleItem
 * @return string
 */
function renderVerMenu($item, $parent = null, $rec = 0, $singleItem = false)
{
    checkRecursion($rec);
    if (! $item) {
        return 'menu misconfiguration';
    }

    if (isset($item['separator'])) {
        echo '<li class="menu-separator"><span></span></li>';
    } elseif (isset($item['section'])) {
        echo '<li class="menu-section '.($rec === 0 ? 'menu-section--first' : '').'">
                <h4 class="menu-text">'.$item['section'].'</h4>
                <i class="menu-icon flaticon-more-v2"></i>
            </li>';
    } elseif (isset($item['title'])) {
        $item_class = '';
        $item_attr = '';

        if (isset($item['submenu'])) {
            $item_class .= ' menu-item-submenu'; // m-menu__item--active

            if (isset($item['toggle']) && $item['toggle'] == 'click') {
                $item_attr .= ' data-menu-toggle="click"';
            } else {
                $item_attr .= ' data-menu-toggle="hover"';
            }

            if (isset($item['mode'])) {
                $item_attr .= ' data-menu-mode="'.$item['mode'].'"';
            }

            if (isset($item['dropdown-toggle-class'])) {
                $item_attr .= ' data-menu-toggle-class="'.$item['dropdown-toggle-class'].'"';
            }
        }

        if (@$item['redirect'] === true) {
            $item_attr .= ' data-menu-redirect="1"';
        }

        // parent item for hoverable submenu
        if (isset($item['parent'])) {
            $item_class .= ' menu-item-parent'; // m-menu__item--active
        }

        // custom class for menu item
        if (isset($item['custom-class'])) {
            $item_class .= ' '.$item['custom-class'];
        }

        if (isset($item['submenu']) && isActiveVerMenuItem($item, request()->path())) {
            $item_class .= ' menu-item-open menu-item-here'; // m-menu__item--active
        } elseif (isActiveVerMenuItem($item, request()->path())) {
            $item_class .= ' menu-item-active';
        }

        echo '<li class="menu-item '.$item_class.'" aria-haspopup="true" '.$item_attr.'>';
        if (isset($item['parent'])) {
            echo '<span class="menu-link">';
        } else {
            $url = '#';

            if (isset($item['page'])) {
                if (isset($item['params'])) {
                    $url = route($item['page'], $item['params']);
                } else {
                    $url = route($item['page']);
                }
            }

            $target = '';
            if (isset($item['new-tab']) && $item['new-tab'] == true) {
                $target = 'target="_blank"';
            }

            echo '<a '.$target.' href="'.$url.'" class="menu-link '.(isset($item['submenu']) ? 'menu-toggle' : '').'">';
        }

        // Menu arrow
        if (@$item['here'] === true) {
            echo '<span class="menu-item-here"></span>';
        }

        // bullet
        $bullet = '';

        if ($parent != null && isset($parent['bullet']) && $parent['bullet'] == 'dot') {
            $bullet = 'dot';
        } elseif ($parent != null && isset($parent['bullet']) && $parent['bullet'] == 'line') {
            $bullet = 'line';
        }

        // Menu icon OR bullet
        if ($bullet == 'dot') {
            echo '<i class="menu-bullet menu-bullet-dot"><span></span></i>';
        } elseif ($bullet == 'line') {
            echo '<i class="menu-bullet menu-bullet-line"><span></span></i>';
        } elseif (config('layout.aside.menu.hide-root-icons') !== true && isset($item['icon']) && ! empty($item['icon'])) {
            renderIcon($item['icon']);
        }

        // Badge
        echo '<span class="menu-text">'.__($item['title']).'</span>';
        if (isset($item['label'])) {
            echo '<span class="menu-badge"><span class="label '.$item['label']['type'].'">'.$item['label']['value'].'</span></span>';
        }

        if ($singleItem == true) {
            if (isset($item['parent'])) {
                echo '</span>';
            } else {
                echo '</a>';
            }

            echo '</li>';

            return '';
        }

        if (isset($item['submenu'])) {
            if (isset($item['root']) == false && config('layout.menu.aside.submenu.arrow') == 'plus-minus') {
                echo '<i class="menu-arrow menu-arrow-pm"><span><span></span></span></i>';
            } elseif (isset($item['root']) == false && config('layout.menu.aside.submenu.arrow') == 'plus-minus-square') {
                echo '<i class="menu-arrow menu-arrow-pm-square"><span><span></span></span></i>';
            } elseif (isset($item['root']) == false && config('layout.menu.aside.submenu.arrow') == 'plus-minus-circle') {
                echo '<i class="menu-arrow menu-arrow-pm-circle"><span><span></span></span></i>';
            } else {
                if (@$item['arrow'] !== false && config('layout.aside.menu.root-arrow') !== false) {
                    echo '<i class="menu-arrow"></i>';
                }
            }
        }

        if (isset($item['parent'])) {
            echo '</span>';
        } else {
            echo '</a>';
        }

        if (isset($item['submenu'])) {
            $submenu_dir = '';
            if (isset($item['submenu-up']) && $item['submenu-up'] === true) {
                $submenu_dir = 'menu-submenu-up';
            }
            echo '<div class="menu-submenu '.$submenu_dir.'">';
            echo '<span class="menu-arrow"></span>';

            if (isset($item['custom-class']) && ($item['custom-class'] === 'menu-item-submenu-stretch' || $item['custom-class'] === 'menu-item-submenu-scroll')) {
                echo '<div class="menu-wrapper">';
            }

            if (isset($item['scroll'])) {
                echo '<div class="menu-scroll" data-scroll="true" style="height: '.$item['scroll'].'">';
            }

            echo '<ul class="menu-subnav">';
            if (isset($item['root'])) {
                $parent_item = $item;
                $parent_item['parent'] = true;
                unset($parent_item['icon']);
                unset($parent_item['submenu']);
                renderVerMenu($parent_item, null, $rec++, true); // single item render
            }
            foreach ($item['submenu'] as $submenu_item) {
                renderVerMenu($submenu_item, $item, $rec++);
            }
            echo '</ul>';

            if (isset($item['scroll']) || isset($item['custom-class']) && $item['custom-class'] === 'menu-item-submenu-stretch') {
                echo '</div>';
            }
            echo '</div>';
        }

        echo '</li>';
    } else {
        foreach ($item as $each) {
            renderVerMenu($each, $parent, $rec++);
        }
    }
}

/**
 * Header menu
 *
 * @param  null  $parent
 * @param  int  $rec
 * @return string
 */
function renderHorMenu($item, $parent = null, $rec = 0)
{
    checkRecursion($rec);
    if (! $item) {
        return 'menu misconfiguration';
    }

    if (! checkPermission($item)) {
        return null;
    }

    // render separator
    if (isset($item['separator'])) {
        echo '<li class="menu-separator"><span></span></li>';
    } elseif (isset($item['title']) || isset($item['code'])) {
        $item_class = '';
        $item_attr = '';

        if (isset($item['submenu']) && isActiveHorMenuItem($item, request()->path())) {
            $item_class .= ' menu-item-open menu-item-here'; // m-menu__item--active

            if (@$item['submenu']['type'] == 'tabs') {
                $item_class .= ' menu-item-active-tab ';
            }
        } elseif (isActiveHorMenuItem($item, request()->path())) {
            $item_class .= ' menu-item-active ';

            if (@$item['submenu']['type'] == 'tabs') {
                $item_class .= ' menu-item-active-tab ';
            }
        }

        if (isset($item['submenu'])) {
            $item_class .= ' menu-item-submenu'; // m-menu__item--active

            if (isset($item['toggle']) && $item['toggle'] == 'click') {
                $item_attr .= ' data-menu-toggle="click"';
            } elseif (@$item['submenu']['type'] == 'tabs') {
                $item_attr .= ' data-menu-toggle="tab"';
            } else {
                $item_attr .= ' data-menu-toggle="hover"';
            }
        }

        if (@$item['redirect'] === true) {
            $item_attr .= ' data-menu-redirect="1"';
        }

        if (isset($item['submenu'])) {
            if (! isset($item['submenu']['type'])) {
                // default option
                $item['submenu']['type'] = 'classic';
                $item['submenu']['alignment'] = 'right';
            }
            if (($item['submenu']['type'] == 'classic') && isset($item['root'])) {
                $item_class .= ' menu-item-rel';
            }

            if (($item['submenu']['type'] == 'mega') && isset($item['root']) && @$item['align'] != 'center') {
                $item_class .= ' menu-item-rel';
            }

            if ($item['submenu']['type'] == 'tabs') {
                $item_class .= ' menu-item-tabs';
            }
        }

        if (isset($item['submenu']['items']) && isActiveHorMenuItem($item['submenu'], request()->path())) {
            $item_class .= ' menu-item-open menu-item-here'; // m-menu__item--active
        }

        if (isset($item['custom-class'])) {
            $item_class .= ' '.$item['custom-class'];
        }

        if (@$item['icon-only'] == true) {
            $item_class .= ' menu-item-icon-only';
        }

        if (isset($item['heading']) == false) {
            echo '<li class="menu-item '.$item_class.'" '.$item_attr.' aria-haspopup="true">';
        }

        // check if code is provided instead of link
        if (isset($item['code'])) {
            echo $item['code'];
        } else {
            // insert title or heading
            if (isset($item['heading']) == false) {
                $url = '#';

                if (isset($item['page'])) {
                    if (isset($item['params'])) {
                        $url = route($item['page'], $item['params']);
                    } else {
                        $url = route($item['page']);
                    }
                }

                $target = '';
                if (isset($item['new-tab']) && $item['new-tab'] == true) {
                    $target = 'target="_blank"';
                }

                echo '<a '.$target.' href="'.$url.'" class="menu-link '.(isset($item['submenu']) ? 'menu-toggle' : '').'">';
            } else {
                echo '<h3 class="menu-heading menu-toggle">';
            }

            // put root level arrow
            if (@$item['here'] === true) {
                echo '<span class="menu-item-here"></span>';
            }

            // bullet
            $bullet = '';

            if ((@$item['heading'] && @$item['bullet'] == 'dot') || @$parent['bullet'] == 'dot') {
                $bullet = 'dot';
            } elseif ((@$item['heading'] && @$item['bullet'] == 'line') || @$parent['bullet'] == 'line') {
                $bullet = 'line';
            }

            // Menu icon OR bullet
            if ($bullet == 'dot') {
                echo '<i class="menu-bullet menu-bullet-dot"><span></span></i>';
            } elseif ($bullet == 'line') {
                echo '<i class="menu-bullet menu-bullet-line"><span></span></i>';
            } elseif (isset($item['icon']) && ! empty($item['icon'])) {
                renderIcon($item['icon']);
            }

            // Badge
            echo '<span class="menu-text">'.__($item['title']).'</span>';
            if (isset($item['label'])) {
                echo '<span class="menu-badge"><span class="label '.$item['label']['type'].'">'.$item['label']['value'].'</span></span>';
            }
            // Arrow
            if (isset($item['submenu']) && (! isset($item['arrow']) || $item['arrow'] != false)) {
                // root down arrow
                if (isset($item['root'])) {
                    // enable/disable root arrow
                    if (config('layout.header.menu.self.root-arrow') !== false) {
                        echo '<i class="menu-hor-arrow"></i>';
                    }
                } else {
                    // inner menu arrow
                    echo '<i class="menu-hor-arrow"></i>';
                }
                echo '<i class="menu-arrow"></i>';
            }

            // closing title or heading
            if (isset($item['heading']) == false) {
                echo '</a>';
            } else {
                echo '<i class="menu-arrow"></i></h3>';
            }

            if (isset($item['submenu'])) {
                if (in_array($item['submenu']['type'], ['classic', 'tabs'])) {
                    if (isset($item['submenu']['alignment'])) {
                        $submenu_class = ' menu-submenu-'.$item['submenu']['alignment'];

                        if (isset($item['submenu']['pull']) && $item['submenu']['pull'] == true) {
                            $submenu_class .= ' menu-submenu-pull';
                        }
                    }

                    if ($item['submenu']['type'] == 'tabs') {
                        $submenu_class .= ' menu-submenu-tabs';
                    }

                    echo '<div class="menu-submenu menu-submenu-classic'.$submenu_class.'">';

                    echo '<ul class="menu-subnav">';
                    $items = [];
                    if (isset($item['submenu']['items'])) {
                        $items = $item['submenu']['items'];
                    } else {
                        $items = $item['submenu'];
                    }
                    foreach ($items as $submenu_item) {
                        renderHorMenu($submenu_item, $item, $rec++);
                    }
                    echo '</ul>';
                    echo '</div>';
                } elseif ($item['submenu']['type'] == 'mega') {
                    $submenu_fixed_width = '';

                    if (intval(@$item['submenu']['width']) > 0) {
                        $submenu_class = ' menu-submenu-fixed';
                        $submenu_fixed_width = 'style="width:'.$item['submenu']['width'].'"';
                    } else {
                        $submenu_class = ' menu-submenu-'.$item['submenu']['width'];
                    }

                    if (isset($item['submenu']['alignment'])) {
                        $submenu_class .= ' menu-submenu-'.$item['submenu']['alignment'];

                        if (isset($item['submenu']['pull']) && $item['submenu']['pull'] == true) {
                            $submenu_class .= ' menu-submenu-pull';
                        }
                    }

                    echo '<div class="menu-submenu '.$submenu_class.'" '.($submenu_fixed_width).'>';

                    echo '<div class="menu-subnav">';
                    echo '<ul class="menu-content">';
                    foreach ($item['submenu']['columns'] as $column) {
                        $item_class = '';
                        // mega menu column header active
                        if (isset($column['items']) && isActiveVerMenuItem($column, request()->path())) {
                            $item_class .= ' menu-item-open menu-item-here'; // m-menu__item--active
                        }

                        echo '<li class="menu-item '.$item_class.'">';
                        if (isset($column['heading'])) {
                            renderHorMenu($column['heading'], null, $rec++);
                        }
                        echo '<ul class="menu-inner">';
                        foreach ($column['items'] as $column_submenu_item) {
                            renderHorMenu($column_submenu_item, $column, $rec++);
                        }
                        echo '</ul>';
                        echo '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }

        if (isset($item['heading']) == false) {
            echo '</li>';
        }
    } elseif (is_array($item)) {
        foreach ($item as $each) {
            renderHorMenu($each, $parent, $rec++);
        }
    }
}
function checkPermission($item)
{
    //check if this layer has permission
    if (isset($item['permission'])) {
        return Auth::user()->can($item['permission']);
    }

    //check if the child's layer has permission
    $items = $item['submenu']['items'] ?? $item['submenu'] ?? null;

    //check if the layer has childes
    if (! $items) {
        return true;
    }

    //for loop on child item
    foreach ($items as $submenu_item) {
        if (checkPermission($submenu_item)) {
            return true;
        }
    }

    // if the for loop didn't have any permission return false
    return false;
}

// Check for active Vertical Menu item
function isActiveVerMenuItem($item, $page, $rec = 0): bool
{
    if (@$item['redirect'] === true) {
        return false;
    }

    checkRecursion($rec);

    if (isset($item['page']) && $item['page'] == $page) {
        return true;
    }

    if (is_array($item)) {
        foreach ($item as $each) {
            if (isActiveVerMenuItem($each, $page, $rec++)) {
                return true;
            }
        }
    }

    return false;
}

// Checks recursion depth
function checkRecursion($rec, $max = 10000)
{
    if ($rec > $max) {
        echo 'Too many recursions!!!';
        exit;
    }
}

// Render icon or bullet
function renderIcon($icon)
{

    if (isSVG($icon)) {
        echo getSVG($icon, 'menu-icon');
    } else {
        echo '<i class="menu-icon '.$icon.'"></i>';
    }

}

function getTextColor($code): string
{
    $rgb = HTMLToRGB($code);
    $hsl = RGBToHSL($rgb);
    if ($hsl->lightness > 200) {
        return 'black';
    } else {
        return 'white';
    }
}

function HTMLToRGB($htmlCode)
{
    if ($htmlCode[0] == '#') {
        $htmlCode = substr($htmlCode, 1);
    }

    if (strlen($htmlCode) == 3) {
        $htmlCode = $htmlCode[0].$htmlCode[0].$htmlCode[1].$htmlCode[1].$htmlCode[2].$htmlCode[2];
    }

    $r = hexdec($htmlCode[0].$htmlCode[1]);
    $g = hexdec($htmlCode[2].$htmlCode[3]);
    $b = hexdec($htmlCode[4].$htmlCode[5]);

    return $b + ($g << 0x8) + ($r << 0x10);
}

function RGBToHSL($RGB): object
{
    $r = 0xFF & ($RGB >> 0x10);
    $g = 0xFF & ($RGB >> 0x8);
    $b = 0xFF & $RGB;

    $r = ((float) $r) / 255.0;
    $g = ((float) $g) / 255.0;
    $b = ((float) $b) / 255.0;

    $maxC = max($r, $g, $b);
    $minC = min($r, $g, $b);

    $l = ($maxC + $minC) / 2.0;

    if ($maxC == $minC) {
        $s = 0;
        $h = 0;
    } else {
        if ($l < .5) {
            $s = ($maxC - $minC) / ($maxC + $minC);
        } else {
            $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
        }
        if ($r == $maxC) {
            $h = ($g - $b) / ($maxC - $minC);
        }
        if ($g == $maxC) {
            $h = 2.0 + ($b - $r) / ($maxC - $minC);
        }
        if ($b == $maxC) {
            $h = 4.0 + ($r - $g) / ($maxC - $minC);
        }

        $h = $h / 6.0;
    }

    $h = (int) round(255.0 * $h);
    $s = (int) round(255.0 * $s);
    $l = (int) round(255.0 * $l);

    return (object) ['hue' => $h, 'saturation' => $s, 'lightness' => $l];
}

function getSVG($filepath, $class = '')
{
    if (! is_string($filepath) || ! file_exists($filepath)) {
        return '';
    }

    $svg_content = file_get_contents($filepath);

    $dom = new \DOMDocument();
    $dom->loadXML($svg_content);

    // remove unwanted comments
    $xpath = new \DOMXPath($dom);
    foreach ($xpath->query('//comment()') as $comment) {
        $comment->parentNode->removeChild($comment);
    }

    // remove unwanted tags
    $title = $dom->getElementsByTagName('title');
    if ($title['length']) {
        $dom->documentElement->removeChild($title[0]);
    }
    $desc = $dom->getElementsByTagName('desc');
    if ($desc['length']) {
        $dom->documentElement->removeChild($desc[0]);
    }
    $defs = $dom->getElementsByTagName('defs');
    if ($defs['length']) {
        $dom->documentElement->removeChild($defs[0]);
    }

    // remove unwanted id attribute in g tag
    $g = $dom->getElementsByTagName('g');
    foreach ($g as $el) {
        $el->removeAttribute('id');
    }
    $mask = $dom->getElementsByTagName('mask');
    foreach ($mask as $el) {
        $el->removeAttribute('id');
    }
    $rect = $dom->getElementsByTagName('rect');
    foreach ($rect as $el) {
        $el->removeAttribute('id');
    }
    $path = $dom->getElementsByTagName('path');
    foreach ($path as $el) {
        $el->removeAttribute('id');
    }
    $circle = $dom->getElementsByTagName('circle');
    foreach ($circle as $el) {
        $el->removeAttribute('id');
    }
    $use = $dom->getElementsByTagName('use');
    foreach ($use as $el) {
        $el->removeAttribute('id');
    }
    $polygon = $dom->getElementsByTagName('polygon');
    foreach ($polygon as $el) {
        $el->removeAttribute('id');
    }
    $ellipse = $dom->getElementsByTagName('ellipse');
    foreach ($ellipse as $el) {
        $el->removeAttribute('id');
    }

    $string = $dom->saveXML($dom->documentElement);

    // remove empty lines
    $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

    $cls = ['svg-icon'];
    if (! empty($class)) {
        $cls = array_merge($cls, explode(' ', $class));
    }

    echo '<span class="'.implode(' ', $cls).'"><!--begin::Svg Icon | path:'.$filepath.'-->'.$string.'<!--end::Svg Icon--></span>';
}

function isSVG($path): bool
{
    if (is_string($path)) {
        return substr(strrchr($path, '.'), 1) === 'svg';
    }

    return false;
}

function isActiveHorMenuItem($item, $page, $rec = 0): bool
{

    //        return false;

    checkRecursion($rec);

    if (isset($item['page']) && $item['page'] == $page) {
        return true;
    }

    if (is_array($item)) {
        foreach ($item as $each) {
            if (isActiveHorMenuItem($each, $page, $rec++)) {
                return true;
            }
        }
    }

    return false;
}
