<?php

namespace App\Helpers;

class Template
{
    public static function btnStatus($params, $id, $statusValue)
    {

        $status = $statusValue == 'active' ? 'inactive' : 'active';
        $class = $statusValue == 'active' ? 'success' : 'danger';
        $link = route($params['prefix'] . '.' . $params['controller'] . '.status', ['id' => $id, 'status' => $statusValue]);
        $icon = $statusValue == 'active' ? '<i class="fa-solid fa-circle-check fa-lg text-success fs-xl"></i>' : '<i class="fa-sharp fa-solid fa-ban fa-lg text-danger fs-xl"></i>';
        $xhtml = sprintf(
            '<a class="btn-change-status text-%s" href="%s">' . $icon . '</i></a>',
            $class,
            $link,
            $status
        );
        return $xhtml;
    }
    public static function InputText($params, $name, $value = null)
    {
        return '
                <div>
                    <div id="kt_ecommerce_add_product_meta_description" name="' . $name . '"
                                    class=" mb-2" style="min-height: 500px">
                                    ' . ($value ?? '') . '
                                    </div>
                                <input type="text" name="' . $name . '" id="hidden_description" class="hidden" hidden>
                                <script>

                                    $("form").on("submit", function(e) {
                                        const html = $("#kt_ecommerce_add_product_meta_description .ql-editor").html();

                                        $("#hidden_description").val(html);
                                    });
                                </script>
                                <div class="text-muted fs-7">Set a description to the project
                                    ranking.</div>
                </div>
                            ';
    }

    public static function adminButtonAction($params, $button, $id, $options = null)
    {
        $tmplButton   = config()->get('component.template.button');


        $xhtml = '<div class="vnbk-box-btn-filter">';

        if (!empty($options) && $options['task'] == 'remove-approval-button') {
            $button = $options['button'];
        }

        foreach ($button as $btn) {

            $currentButton = $tmplButton[$btn];
            $link = route($params['prefix'] . '.' . $params['controller'] .  $currentButton['route-name'], [str_replace('-', '_', $params['controller']) => $id]);

            $xhtml .= sprintf(
                '<a  %s %s type="button" class="btn btn-sm   %s px-1 py-0 btn btn-sm btn-icon btn-active-light-primary me-2" data-toggle="tooltip" data-placement="top"
                    data-original-title="%s">
                    <i class="fa-sharp fa-solid %s %s"></i>
                </a>&nbsp;',
                $btn == "delete" ? '' : "href='$link'",
                $btn == "delete" ?  "onclick='confirmDeletion(\"" . $id . "\",\"" . route($params['prefix'] . '.' . $params['controller'] .  '.confirm-delete') . "\")'" : '',
                $currentButton['class'],
                $currentButton['title'],
                $currentButton['icon'],
                $currentButton['class']
            );
        }

        $xhtml .= '</div>';

        return $xhtml;
    }
    public static function renderHtmlTypeBadge($value, $arrayType)
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
    public static function formatPrice($price)
    {
        $price_formatted = number_format($price, 0, ',', '.');
        return '<span class="price text-primary align-center">' . $price_formatted . 'đ</span>';
    }
    public static function renderAddressHtml($params, $options = [])
    {
        $apiAddressUrl      = route('admin.country.address');

        $name               = $params['field'] ?? '';
        $parentId           = $params['parent_id'] ?? null;
        $parentName         = $params['parent_name'] ?? null;
        $nextField          = $params['next'] ?? null;

        $model              = new \App\Models\Admin\CountryModel();
        $data               = [];

        if ($name == 'country_id') {
            $data           = $model->listItem($params, ['task' => 'address']);
        } elseif ($parentId) {
            $data           = $model->listItem(['type' => $parentName, 'id' => $parentId], ['task' => 'address']);
        }

        // Tạo option
        $optionsHtml        = '<option value="">-- Chọn --</option>';
        foreach ($data ?? [] as $item) {

            $selected       = $item['id'] ==  $params['id'] ? 'selected' : '';
            $optionsHtml    .= sprintf(
                '<option value="%s" %s>%s</option>',
                htmlspecialchars($item['id']),
                $selected,
                htmlspecialchars($item['name'])
            );
        }

        // kết quả
        return sprintf(
            '
            <div class="%s">
                <label class="%s" for="%s">
                    %s %s
                </label>
                <select
                    %s
                    class="form-control helper_select_address"
                    data-next="%s"
                    data-control="select2"
                    data-dropdown-css-class="select2-primary"
                    id="%s"
                    name="%s"
                >
                    %s
                </select>
                <div class="input-error"></div>
            </div>',
            htmlspecialchars($options['class_group']),
            htmlspecialchars($options['class_label']),
            htmlspecialchars($name),
            htmlspecialchars($options['label']),
            $options['required'] ? '<span style="color: red">(*)</span>' : '',
            $nextField ? 'onChange="helperSelectAddress(this,\'' . $apiAddressUrl . '\')"' : '',
            htmlspecialchars($nextField),
            htmlspecialchars($name),
            htmlspecialchars($name),
            $optionsHtml
        );
    }


    public static function address($params = null, $options = [])
    {

        $options        = [
            'class_group'   => 'col-12 col-lg-3 form-group p-2 mb-0',
            'class_label'   => 'font-weight-normal',
            'required'      => false,
            ...$options
        ];

        $labels         = [
            'country_id'    => 'Quốc gia',
            'province_id'   => 'Tỉnh/ Thành phố',
            'ward_id'       => 'Phường/ Xã'
        ];

        if (!$params) {
            $params     = [
                'country_id'    => null,
                'province_id'       => null,
                'ward_id'       => null
            ];
        }

        $html           = '';
        $keys           = array_keys($params);
        $count          = count($keys);

        foreach ($keys as $index => $field) {
            $dataItem   = [
                'field'         => $field,
                'next'          => $index < $count - 1 ? $keys[$index + 1] : null,
                'id'            => $params[$field],
                'parent_id'     => $index > 0 ? $params[$keys[$index - 1]] : null,
                'parent_name'   => $index > 0 ? $keys[$index - 1] : null
            ];

            $options['label']   = $labels[$field] ?? $field;

            $html               .= self::renderAddressHtml($dataItem, $options);
        }
        return $html;
    }
}
