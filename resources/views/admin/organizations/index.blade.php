@inject('request', 'Illuminate\Http\Request')
@extends('layouts.admin')

@section('content')
    <h3 class="page-title">@lang('global.organizations.title')</h3>
    <p>
        <a href="{{ route('admin.organizations.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($organizations) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>

                        <th>@lang('global.organizations.fields.name')</th>
                        <th>@lang('global.organizations.fields.email')</th>
                        <th>@lang('global.organizations.fields.users')</th>
                        <th>&nbsp;</th>

                    </tr>
                </thead>
                
                <tbody>
                    @if (count($organizations) > 0)
                        @foreach ($organizations as $organization)
                            <tr data-entry-id="{{ $organization->id }}">
                                <td></td>

                                <td>{{ $organization->name }}</td>
                                <td>{{ $organization->email }}</td>
                                <td>
                                    @foreach ($organization->users()->pluck('name') as $user)
                                        <span class="label label-info label-many">{{ $user }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.organizations.edit',[$organization->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    {!! Form::open([
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => 'return confirm("' . trans('global.app_are_you_sure') . '");',
                                        'route' => ['admin.organizations.destroy', $organization->id]
                                    ]) !!}
                                    {!! Form::submit(trans('global.app_delete'), ['class' => 'btn btn-xs btn-danger']) !!}
                                    {!! Form::close() !!}
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.organizations.mass_destroy') }}';
    </script>
@endsection
