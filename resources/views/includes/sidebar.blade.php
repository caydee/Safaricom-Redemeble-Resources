<div class="wrapper">
    <nav class="sidebar sidebar-sticky">
        <div class="sidebar-content  js-simplebar">
            <a class="sidebar-brand" href="{{ url('/') }}">
                <img src="{{ asset($logo) }}" alt="Logo" class="img-fluid">
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    Main
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('backend') }}" class="font-weight-bold  sidebar-link">
                        <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                @isOwner
                <li class="sidebar-item">
                    <a href="{{ route('organization.index') }}"  class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="sidebar"></i> <span class="align-middle">Organizations</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('access_type.index') }}"  class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="anchor"></i> <span class="align-middle">Access Types</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('product_type.index') }}"  class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="folder-plus"></i> <span class="align-middle">Product Types</span>
                    </a>
                </li>
                @endisOwner

                <li class="sidebar-item">
                    <a href="{{ route('product.index') }}"  class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Products</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('rates.index') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Rates</span>
                    </a>
                </li>
                <li class="sidebar-header">
                    Financial
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('disbursement.index') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="send"></i> <span class="align-middle">Bulk disbursement</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('transaction.index') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Transactions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('credits.index') }}" class="font-weight-bold sidebar-link">
                        <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Credits</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#vouchers" data-toggle="collapse" class="font-weight-bold sidebar-link" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list align-middle"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg> <span class="align-middle">
                            Voucher Management
                        </span>
                    </a>
                    <ul id="vouchers" class="sidebar-dropdown list-unstyled collapse" style="">
                        <a href="{{ route('vouchers.batches') }}" class="font-weight-bold sidebar-link">
                            <i class="align-middle " data-feather="briefcase"></i> <span class="align-middle">Batches</span>
                        </a>
                        <a href="{{ route('vouchers.list') }}" class="font-weight-bold sidebar-link">
                            <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Vouchers</span>
                        </a>
                    </ul>
                </li>
                <li class="sidebar-header">
                   Queue Reporting
                </li>
                <li class="sidebar-item">
                    <a href="#tables" data-toggle="collapse" class="font-weight-bold sidebar-link" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list align-middle"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg> <span class="align-middle">Queue Management</span>
                    </a>
                    <ul id="tables" class="sidebar-dropdown list-unstyled collapse" style="">
                        <a class="sidebar-link font-weight-bold " href="{{ route('job.queued') }}"><i class="align-middle" data-feather="wind"></i>Queued</a>
                        <a class="sidebar-link font-weight-bold " href="{{ route('job.failed') }}"><i class="align-middle" data-feather="monitor"></i>Failed</a>
                    </ul>
                </li>

                <li class="sidebar-header">
                    Developer Options
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ route('documentation') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Documentation</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ url('backend/security/credentials') }}">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">API Credentials</span>
                    </a>
                </li>
                <li class="sidebar-header">
                    Customer Care
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ route('ticket_category.index') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Ticket Categories</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#tickets" data-toggle="collapse" class="font-weight-bold sidebar-link" aria-expanded="true">
                        <i class="align-middle" data-feather="paperclip"></i>Tickets
                    </a>
                    <ul id="tickets" class="sidebar-dropdown list-unstyled collapse" style="">
                        <a class="sidebar-link font-weight-bold " href="{{ route('category.ticket.index',0) }}">
                            FAQ
                        </a>
                        <a class="sidebar-link font-weight-bold " href="{{ route('category.ticket.index',1) }}">
                            Tickets
                            <span class="badge badge-info">0</span>
                        </a>
                    </ul>
                </li>
                <li class="sidebar-header">
                    Administration
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ route('user.index') }}">
                        <i class="align-middle" data-feather="users"></i> <span class="align-middle">Users</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ route('user.role.index',0) }}">
                        <i class="align-middle fas fa-tasks"></i> <span class="align-middle">Roles</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ route('user.permission.index',0) }}">
                        <i class="align-middle fas fa-door-open"></i> <span class="align-middle">Permissions</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link font-weight-bold" href="{{ route('log.index') }}">
                        <i class="align-middle fas fa-edit" ></i>
                        <span class="align-middle">Logs</span>
                    </a>
                </li>
            </ul>


        </div>
    </nav>

