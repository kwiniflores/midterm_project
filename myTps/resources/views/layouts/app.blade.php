<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechSales - Transaction Processing System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">

<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-sm border-r border-gray-100 transform lg:translate-x-0 transition-transform duration-300 ease-in-out" id="sidebar">
    <!-- Logo Section -->
    <div class="flex items-center justify-center h-20 bg-white border-b border-gray-100">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-cash-register text-gray-700 text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">TechSales</h1>
                <p class="text-xs text-gray-500">Transaction System</p>
            </div>
        </div>
    </div>
   
    <!-- Navigation Menu -->
    <nav class="mt-8 px-4">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('sales.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ request()->routeIs('sales.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                <i class="fas fa-chart-line w-5 h-5 mr-3 text-gray-500"></i>
                <span class="font-medium">Sales</span>
            </a>
           
            <!-- Customers -->
            <a href="{{ route('customers.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ request()->routeIs('customers.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                <i class="fas fa-users w-5 h-5 mr-3 text-gray-500"></i>
                <span class="font-medium">Customers</span>
            </a>
           
            <!-- Products -->
            <a href="{{ route('products.index') }}" class="flex items-center px-3 py-2 text-gray-700 rounded-md hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150 {{ request()->routeIs('products.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                <i class="fas fa-box w-5 h-5 mr-3 text-gray-500"></i>
                <span class="font-medium">Products</span>
            </a>
        </div>
       
        <!-- Divider -->
        <div class="my-6 border-t border-gray-100"></div>
       
        <!-- Quick Actions -->
        <div>
            <h3 class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider mb-3">Quick Actions</h3>
            <div class="space-y-1">
                <a href="{{ route('sales.create') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150">
                    <i class="fas fa-plus w-4 h-4 mr-3 text-gray-400"></i>
                    <span>New Sale</span>
                </a>
                <a href="{{ route('customers.create') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150">
                    <i class="fas fa-user-plus w-4 h-4 mr-3 text-gray-400"></i>
                    <span>Add Customer</span>
                </a>
                <a href="{{ route('products.create') }}" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-md hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150">
                    <i class="fas fa-plus-square w-4 h-4 mr-3 text-gray-400"></i>
                    <span>Add Product</span>
                </a>
            </div>
        </div>
    </nav>
</div>

<!-- Mobile menu button -->
<div class="lg:hidden fixed top-4 left-4 z-50">
    <button id="mobile-menu-button" class="bg-white p-2 rounded-lg shadow-md">
        <i class="fas fa-bars text-gray-600"></i>
    </button>
</div>

<!-- Main Content -->
<div class="lg:ml-64 min-h-screen">
    <!-- Top Header -->
    <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-40">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Page Title Area -->
                <div class="flex items-center space-x-4">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-900">
                            @if(request()->routeIs('sales.*'))
                                <i class="fas fa-chart-line text-gray-600 mr-2"></i>Sales Management
                            @elseif(request()->routeIs('customers.*'))
                                <i class="fas fa-users text-gray-600 mr-2"></i>Customer Management
                            @elseif(request()->routeIs('products.*'))
                                <i class="fas fa-box text-gray-600 mr-2"></i>Product Management
                            @else
                                <i class="fas fa-tachometer-alt text-gray-600 mr-2"></i>Dashboard
                            @endif
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            @if(request()->routeIs('sales.*'))
                                Manage your sales transactions and invoices
                            @elseif(request()->routeIs('customers.*'))
                                Manage customer information and history
                            @elseif(request()->routeIs('products.*'))
                                Manage inventory and product catalog
                            @else
                                Welcome to your business dashboard
                            @endif
                        </p>
                    </div>
                </div>
               
                <!-- Right Side Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Time Display -->
                    <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                        <i class="fas fa-clock text-gray-400"></i>
                        <span id="current-time"></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Alert Messages -->
    <div class="px-6 py-4">
        <!-- Success Message -->
        @if (session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 rounded-xl px-6 py-4 flex items-center shadow-sm">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
            <button class="ml-auto text-green-400 hover:text-green-600" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <!-- Error Message -->
        @if (session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 rounded-xl px-6 py-4 flex items-center shadow-sm">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button class="ml-auto text-red-400 hover:text-red-600" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="px-6 pb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 min-h-[600px]">
            <div class="p-6">
                <!-- Content goes here -->
                @yield('content')
            </div>
        </div>
    </main>
   
   
<!-- Scripts -->
<script>
// Mobile menu toggle
document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
});

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const menuButton = document.getElementById('mobile-menu-button');
   
    if (!sidebar.contains(event.target) && !menuButton.contains(event.target)) {
        sidebar.classList.add('-translate-x-full');
    }
});

// Current time display
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', {
        hour12: true,
        hour: 'numeric',
        minute: '2-digit'
    });
    const dateString = now.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric'
    });
   
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = `${dateString}, ${timeString}`;
    }
}

// Update time every minute
updateTime();
setInterval(updateTime, 60000);

// Common JavaScript functions (SAME AS BEFORE)
function confirmDelete(message = 'Are you sure you want to delete this item?') {
    return confirm(message);
}

// Add smooth scrolling
document.documentElement.style.scrollBehavior = 'smooth';
</script>

</body>
</html>