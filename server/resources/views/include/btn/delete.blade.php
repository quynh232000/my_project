<a onclick="return confirm('Are you sure to delete this action!')"
    href="{{route($params['prefix'] . '.' . $params['controller'] . '.destroy',1)}}"
    class="btn btn-danger " data-toggle="tooltip" data-placement="top"
    data-original-title="{{isset($title) ? $title : 'Delete'}}">
    <i class="fa-sharp fa-solid ki-outline ki-trash m-0 text-white pr-0">&nbsp;&nbsp;</i>
    {{isset($title) ? $title : 'Delete'}}
</a>
