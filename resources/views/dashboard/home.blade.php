@include('dashboard.layout.header')

<div class="container mx-auto p-4 bg-gray-800 text-white" style="max-width: 1200px; margin-left: auto; margin-right: auto; padding: 1rem;">
  <h1 class="text-2xl font-bold mb-4" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Dashboard Overview</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6" style="display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 1.5rem; @media (min-width: 768px) { grid-template-columns: repeat(3, minmax(0, 1fr)); }">
    <!-- Left Column: Recent Activity -->
    <div class="md:col-span-2" style="@media (min-width: 768px) { grid-column: span 2 / span 2; }">
      <div class="bg-gray-700 shadow rounded p-4" style="background-color: rgb(55 65 81); box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); border-radius: 0.25rem; padding: 1rem;">
        <h2 class="text-lg font-semibold mb-3 text-white" style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.75rem;">Recent Activity</h2>
         <ul class="divide-y divide-gray-600" style="border-top-width: 1px; border-color: rgb(75 85 99);">
            <li class="py-3" style="padding-top: 0.75rem; padding-bottom: 0.75rem;">
                <div class="flex items-center" style="display: flex; align-items: center;">
                    <div class="mr-4" style="margin-right: 1rem;">
                        <i class="fas fa-user text-gray-400 fa-lg" style="color: rgb(160 174 192); font-size: 1.25rem;"></i>
                    </div>
                    <div class="flex-1" style="flex: 1 1 0%;">
                        <p class="font-medium text-white" style="font-weight: 500;">New user <span class="font-bold" style="font-weight: bold;">Jane Doe</span> registered.</p>
                        <p class="text-sm text-gray-400" style="font-size: 0.875rem; color: rgb(160 174 192);">5 minutes ago</p>
                    </div>
                </div>
            </li>
            <li class="py-3" style="padding-top: 0.75rem; padding-bottom: 0.75rem;">
                <div class="flex items-center" style="display: flex; align-items: center;">
                    <div class="mr-4" style="margin-right: 1rem;">
                        <i class="fas fa-comment text-gray-400 fa-lg" style="color: rgb(160 174 192); font-size: 1.25rem;"></i>
                    </div>
                    <div class="flex-1" style="flex: 1 1 0%;">
                    <p class="font-medium text-white" style="font-weight: 500;">User <span class="font-bold" style="font-weight: bold;">John Smith</span> posted a comment.</p>
                    <p class="text-sm text-gray-400" style="font-size: 0.875rem; color: rgb(160 174 192);">15 minutes ago</p>
                    </div>
                </div>
            </li>
            <li class="py-3" style="padding-top: 0.75rem; padding-bottom: 0.75rem;">
                <div class="flex items-center" style="display: flex; align-items: center;">
                    <div class="mr-4" style="margin-right: 1rem;">
                        <i class="fas fa-file-alt text-gray-400 fa-lg" style="color: rgb(160 174 192); font-size: 1.25rem;"></i>
                    </div>
                    <div class="flex-1" style="flex: 1 1 0%;">
                    <p class="font-medium text-white" style="font-weight: 500;">New blog post published by Admin.</p>
                    <p class="text-sm text-gray-400" style="font-size: 0.875rem; color: rgb(160 174 192);">1 hour ago</p>
                    </div>
                </div>
            </li>
            </ul>
      </div>
    </div>

    <!-- Right Column: Key Metrics -->
    <div class="md:col-span-1" style="@media (min-width: 768px) { grid-column: span 1 / span 1; }">
        <div class="grid grid-cols-1 gap-4" style="display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 1rem;">
           <div class="bg-gray-700 shadow rounded p-4" style="background-color: rgb(55 65 81); box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); border-radius: 0.25rem; padding: 1rem;">
                <h2 class="text-lg font-semibold mb-2 text-white" style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Total Users</h2>
                <p class="text-3xl font-bold text-white" style="font-size: 1.875rem; font-weight: bold;">12,543</p>
            </div>
           <div class="bg-gray-700 shadow rounded p-4" style="background-color: rgb(55 65 81); box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); border-radius: 0.25rem; padding: 1rem;">
                <h2 class="text-lg font-semibold mb-2 text-white" style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Active Users</h2>
                <p class="text-3xl font-bold text-white" style="font-size: 1.875rem; font-weight: bold;">8,210</p>
            </div>
            <div class="bg-gray-700 shadow rounded p-4" style="background-color: rgb(55 65 81); box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); border-radius: 0.25rem; padding: 1rem;">
                <h2 class="text-lg font-semibold mb-2 text-white" style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Total Posts</h2>
                <p class="text-3xl font-bold text-white" style="font-size: 1.875rem; font-weight: bold;">5,345</p>
            </div>
              <div class="bg-gray-700 shadow rounded p-4" style="background-color: rgb(55 65 81); box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); border-radius: 0.25rem; padding: 1rem;">
                    <h2 class="text-lg font-semibold mb-2 text-white" style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Total Comments</h2>
                    <p class="text-3xl font-bold text-white" style="font-size: 1.875rem; font-weight: bold;">2,567</p>
              </div>
       </div>

    </div>
  </div>
</div>

@include('dashboard.layout.footer')