<?php

namespace App\Helpers;

class Template
{
     public static function btnStatus($params, $id, $statusValue)
    {

        $status = $statusValue == 'active' ? 'inactive' : 'active';
        $class = $statusValue == 'active' ? 'success' : 'danger';
        $link = route($params['prefix'] . '.' . $params['controller'] . '.status',['id' => $id, 'status'=>$statusValue ]);
        $icon = $statusValue == 'active' ? '<i class="fa-solid fa-circle-check fa-lg text-success fs-xl"></i>' : '<i class="fa-sharp fa-solid fa-ban fa-lg text-danger fs-xl"></i>';
        $xhtml = sprintf(
            '<a class="btn-change-status text-%s" href="%s">'.$icon.'</i></a>',
            $class,
            $link,
            $status
        );
        return $xhtml;
    }

     public static function adminButtonAction($params, $button, $id, $options = null)
    {
        $tmplButton   = config()->get('component.template.button');


        $xhtml = '<div class="vnbk-box-btn-filter">';

        if(!empty($options) && $options['task'] == 'remove-approval-button'){
            $button = $options['button'];
        }

        foreach ($button as $btn) {

            $currentButton = $tmplButton[$btn];
            $link = route($params['prefix'] . '.' . $params['controller'] .  $currentButton['route-name'], [str_replace('-','_',$params['controller']) => $id]);

            $xhtml .= sprintf(
                '<a href="'.route($params['prefix'] . '.' . $params['controller'] .  '.destroy',1).'" %s %s type="button" class="btn btn-sm   %s px-1 py-0 btn btn-sm btn-icon btn-active-light-primary me-2" data-toggle="tooltip" data-placement="top"
                    data-original-title="%s">
                    <i class="fa-sharp fa-solid %s %s"></i>
                </a>&nbsp;' ,
                $btn == "delete" ? '' : "href='$link'",
                $btn == "delete" ?  "onclick='return confirm('Are you sure tho delete this action?')'":'',
                $currentButton['class'],
                $currentButton['title'],
                $currentButton['icon'],
                $currentButton['class']
            );
        }

        $xhtml .= '</div>';

        return $xhtml;
    }
    public static function renderHtmlTypeBadge($value,$arrayType)
    {
        $bg = "danger";
        switch ($value) {
            case 1:
                $bg = "success";
                break;
            default:
                $bg = "danger";
                break;
        }
        $xhtml = "<span class='badge badge-" . $bg . "'>" .  $arrayType[$value]  . "</span>";

        return $xhtml;
    }
    public static function formatPrice($price) {
        $price_formatted = number_format($price, 0, ',', '.');
        return '<span class="price text-primary align-center">' . $price_formatted . 'đ</span>';
    }
}
