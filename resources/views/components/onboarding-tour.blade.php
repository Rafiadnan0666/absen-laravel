@php
$role = auth()->user()->role?->nama_role ?? 'employee';

$steps = match($role) {
    'admin' => [
        [
            'selector' => '#tour-welcome',
            'title' => 'Welcome to Admin Dashboard!',
            'desc' => 'This is your command center. From here you manage the entire attendance & HR system — users, attendance, leaves, payroll, and reimbursements. The header also shows today\'s date and system status.',
            'icon' => 'fa-tachometer-alt',
            'placement' => 'bottom',
        ],
        [
            'selector' => '#tour-stats',
            'title' => 'Real-Time Metrics',
            'desc' => 'Eight stat cards give you instant insight: total users, employees (active/inactive), departments, total/pending leaves, pending reimbursements, today\'s attendance breakdown (present/late/absent), and this month\'s payroll total with paid/pending status.',
            'icon' => 'fa-chart-simple',
            'placement' => 'bottom',
        ],
        [
            'selector' => '#tour-charts',
            'title' => 'Data Visualizations',
            'desc' => 'Five charts help you spot trends at a glance: Monthly Attendance Trend (line chart comparing present/late/absent over months), Department Distribution (bar chart), Today\'s Attendance (doughnut), Leave Status (doughnut), and Monthly Payroll (bar chart). Hover or tap any data point for details.',
            'icon' => 'fa-chart-bar',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-recent-attendance',
            'title' => 'Recent Attendance',
            'desc' => 'Shows the latest check-ins with employee name, date, and status (PRESENT/LATE/ABSENT). Click "View All" to open the full Attendance page where you can filter by date range, export CSV, and review detailed records.',
            'icon' => 'fa-calendar-check',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-leaves-reimbursements',
            'title' => 'Leaves & Reimbursements',
            'desc' => 'Quickly review recent leave requests and reimbursement claims — employee, type, amount, and approval status. Click "View All" to access the full management pages where you can approve/reject individually or in bulk.',
            'icon' => 'fa-calendar-alt',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-payrolls',
            'title' => 'Payroll Overview',
            'desc' => 'See recent payroll records with employee name, total amount, and payment status (paid/pending). Click "View All" to process payroll, generate payslips, or export data.',
            'icon' => 'fa-money-bill-wave',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-sidebar',
            'title' => 'Sidebar Navigation',
            'desc' => 'The sidebar gives you access to every module — Departments, Announcements, Users, Attendance, Attendance Logs, Leaves, Payroll, Reimbursements, Settings, Reports, and Holidays. Each item opens that section\'s full management page with filtering, bulk actions, and CSV export. Profile & Logout are at the bottom.',
            'icon' => 'fa-bars',
            'placement' => 'right',
        ],
        [
            'selector' => '#tour-welcome',
            'title' => 'You\'re All Set!',
            'desc' => 'You\'ve completed the admin tour. Start exploring — check your dashboard daily for pending items, use the charts to spot trends, and manage everything from the sidebar. Click your profile at the bottom of the sidebar to view or update your account info.',
            'icon' => 'fa-check-circle',
            'placement' => 'bottom',
        ],
    ],
    'hr' => [
        [
            'selector' => '#tour-welcome',
            'title' => 'Welcome to HR Dashboard!',
            'desc' => 'Your HR workspace gives you focused access to attendance monitoring, leave approval, reimbursement processing, and payroll viewing. Let\'s walk through what you can do here.',
            'icon' => 'fa-tachometer-alt',
            'placement' => 'bottom',
        ],
        [
            'selector' => '#tour-stats',
            'title' => 'HR Metrics',
            'desc' => 'Three cards show critical stats: how many employees checked in today, pending leave requests that need your review, and pending reimbursement claims awaiting approval.',
            'icon' => 'fa-chart-simple',
            'placement' => 'bottom',
        ],
        [
            'selector' => '#tour-today-attendance',
            'title' => 'Today\'s Attendance',
            'desc' => 'A full list of everyone who checked in today — employee name, check-in time, check-out time, and attendance status (present/late/absent). Click "View All" to open the full Attendance page with filters and history.',
            'icon' => 'fa-clipboard-list',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-pending-leaves',
            'title' => 'Pending Leaves',
            'desc' => 'Leave requests that need your decision. Review the employee name, leave type (sick, annual, etc.), and period. Approve (✓) or reject (✕) directly from this table. Click "View All" to see all leave records.',
            'icon' => 'fa-calendar-times',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-pending-reimbursements',
            'title' => 'Pending Reimbursements',
            'desc' => 'Employee expense claims waiting for approval. See the category, amount in Rupiah, and use the ✓/✕ buttons to approve or reject. Click "View All" to manage all reimbursement requests.',
            'icon' => 'fa-file-invoice-dollar',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-welcome',
            'title' => 'You\'re All Set!',
            'desc' => 'You\'ve completed the HR tour. Use the sidebar to navigate between Attendance, Leaves, Payroll, and Reimbursements. Need admin-level access? Contact your system administrator.',
            'icon' => 'fa-check-circle',
            'placement' => 'bottom',
        ],
    ],
    default => [
        [
            'selector' => '#tour-welcome',
            'title' => 'Welcome to Employee Panel!',
            'desc' => 'This is your personal workspace. You can check in/out, view your attendance history, request leave, submit reimbursements, check payslips, and read announcements — all from here.',
            'icon' => 'fa-tachometer-alt',
            'placement' => 'bottom',
        ],
        [
            'selector' => '#tour-today-status',
            'title' => 'Today\'s Overview',
            'desc' => 'Four cards show your status at a glance: whether you\'ve checked in today (and if you\'re present/late/absent), your assigned shift, your salary, and your department.',
            'icon' => 'fa-check',
            'placement' => 'bottom',
        ],
        [
            'selector' => '#tour-attendance-detail',
            'title' => 'Attendance Detail',
            'desc' => 'Your detailed today\'s attendance card shows status, check-in/check-out times, work hours, lateness minutes, and overtime. If you haven\'t checked in yet, a "Check In Now" button appears here.',
            'icon' => 'fa-calendar-day',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-my-info',
            'title' => 'My Info',
            'desc' => 'Your personal details — name, email, phone, job title, salary type, join date, and account status. Update your profile anytime by clicking "Profile" in the sidebar.',
            'icon' => 'fa-user-circle',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-shift',
            'title' => 'Shift Schedule',
            'desc' => 'Today\'s shift details including shift name, start time, end time, and late tolerance in minutes. This helps you know exactly when you\'re expected to check in and out.',
            'icon' => 'fa-clock',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-recent-attendance',
            'title' => 'Attendance History',
            'desc' => 'Your recent attendance records — date, check-in time, and status. Click "View All" to see your full attendance history and track your monthly attendance pattern.',
            'icon' => 'fa-history',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-leaves',
            'title' => 'Leave Records',
            'desc' => 'Your leave requests — type (sick, annual, etc.), date period, and approval status (approved/pending/rejected). Click "View All" to submit a new leave request.',
            'icon' => 'fa-calendar-alt',
            'placement' => 'top',
        ],
        [
            'selector' => '#tour-welcome',
            'title' => 'You\'re All Set!',
            'desc' => 'You\'ve completed the employee tour. Use the sidebar to navigate Attendance, Leaves, Reimbursements, Payroll, and Announcements. Don\'t forget to check in every day using the "Check In/Out" button in the top navbar!',
            'icon' => 'fa-check-circle',
            'placement' => 'bottom',
        ],
    ],
};
@endphp

<div x-data="onboardingTour()" x-show="open" x-cloak
     class="fixed inset-0 z-[9999]"
     style="display: none;">
    {{-- Dark overlay with spotlight hole --}}
    <div class="absolute inset-0" style="pointer-events: auto;">
        <div x-ref="hole"
             :style="`left: ${holeX}px; top: ${holeY}px; width: ${holeWidth}px; height: ${holeHeight}px;`"
             class="absolute rounded-xl"
             style="box-shadow: 0 0 0 9999px rgba(0,0,0,0.65); pointer-events: none; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
            {{-- Pulse ring around the spotlight --}}
            <div class="absolute -inset-1 rounded-xl border-2 border-white/70 animate-pulse-slow"></div>
        </div>
    </div>

    {{-- Tooltip card --}}
    <div x-ref="tooltip"
         :style="`left: ${tooltipX}px; top: ${tooltipY}px;`"
         class="absolute bg-white rounded-2xl shadow-2xl p-6 w-80"
         style="pointer-events: auto; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
        {{-- Progress bar --}}
        <div class="flex items-center gap-1 mb-4">
            <template x-for="(step, index) in steps" :key="index">
                <div :class="index <= currentStep ? 'bg-purple-600' : 'bg-slate-200'"
                     class="h-1 flex-1 rounded-full transition-all duration-300"></div>
            </template>
        </div>

        <div class="flex items-start gap-4 mb-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center text-white text-xl shadow-md shrink-0">
                <i :class="'fas ' + steps[currentStep].icon"></i>
            </div>
            <div class="min-w-0">
                <h3 class="text-lg font-bold text-slate-800 mb-1" x-text="steps[currentStep].title"></h3>
                <p class="text-slate-500 text-xs leading-relaxed" x-text="steps[currentStep].desc"></p>
            </div>
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
            <button @click="closeTour()" class="text-sm text-slate-400 hover:text-slate-600 transition-colors font-medium">
                <i class="fas fa-times mr-1"></i> Skip
            </button>
            <div class="flex gap-2">
                <button x-show="currentStep > 0" @click="prevStep()"
                    class="px-3 py-2 text-sm font-semibold text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button @click="nextStep()"
                    class="px-5 py-2 text-sm font-bold text-white uppercase rounded-xl bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 transition-all">
                    <span x-text="currentStep === steps.length - 1 ? 'Done' : 'Next'"></span>
                    <i x-show="currentStep < steps.length - 1" class="fas fa-arrow-right ml-1"></i>
                </button>
            </div>
        </div>

        {{-- Step counter --}}
        <div class="text-center mt-3">
            <span class="text-xs text-slate-400 font-medium" x-text="`${currentStep + 1} / ${steps.length}`"></span>
        </div>
    </div>
</div>

<script>
(function() {
    var tourData = {
        open: {{ session('show_tour') ? 'true' : 'false' }},
        currentStep: 0,
        steps: @json($steps),
        holeX: 0,
        holeY: 0,
        holeWidth: 0,
        holeHeight: 0,
        tooltipX: 0,
        tooltipY: 0,

        init() {
            if (this.open) {
                this.$nextTick(() => this.renderStep());
            }
        },

        renderStep() {
            var step = this.steps[this.currentStep];
            var el = document.querySelector(step.selector);
            if (!el) {
                el = document.querySelector('#tour-welcome');
            }
            if (!el) return;

            var rect = el.getBoundingClientRect();
            var scrollY = window.scrollY;
            var scrollX = window.scrollX;

            this.holeX = rect.left + scrollX;
            this.holeY = rect.top + scrollY;
            this.holeWidth = Math.max(rect.width, 20);
            this.holeHeight = Math.max(rect.height, 20);

            el.scrollIntoView({ behavior: 'smooth', block: 'center' });

            var self = this;
            setTimeout(function() {
                var updatedRect = el.getBoundingClientRect();
                self.holeX = updatedRect.left + window.scrollX;
                self.holeY = updatedRect.top + window.scrollY;
                self.holeWidth = Math.max(updatedRect.width, 20);
                self.holeHeight = Math.max(updatedRect.height, 20);
                self.positionTooltip(step.placement, updatedRect);
            }, 400);
        },

        positionTooltip(placement, targetRect) {
            var tw = 320;
            var th = 280;
            var gap = 16;
            var vw = window.innerWidth;
            var vh = window.innerHeight;
            var scrollX = window.scrollX;
            var scrollY = window.scrollY;

            var x, y;

            switch (placement) {
                case 'bottom':
                    x = targetRect.left + (targetRect.width / 2) - (tw / 2) + scrollX;
                    y = targetRect.bottom + gap + scrollY;
                    break;
                case 'top':
                    x = targetRect.left + (targetRect.width / 2) - (tw / 2) + scrollX;
                    y = targetRect.top - th - gap + scrollY;
                    break;
                case 'left':
                    x = targetRect.left - tw - gap + scrollX;
                    y = targetRect.top + (targetRect.height / 2) - (th / 2) + scrollY;
                    break;
                case 'right':
                    x = targetRect.right + gap + scrollX;
                    y = targetRect.top + (targetRect.height / 2) - (th / 2) + scrollY;
                    break;
                default:
                    x = targetRect.left + (targetRect.width / 2) - (tw / 2) + scrollX;
                    y = targetRect.bottom + gap + scrollY;
            }

            if (x < 16) x = 16;
            if (x + tw > vw + scrollX - 16) x = vw + scrollX - tw - 16;
            if (y < 16) y = targetRect.bottom + gap + scrollY;
            if (y + th > vh + scrollY - 16) {
                if (placement === 'bottom' || placement === 'top') {
                    y = targetRect.top - th - gap + scrollY;
                } else {
                    y = vh + scrollY - th - 16;
                }
            }

            this.tooltipX = Math.max(16, x);
            this.tooltipY = Math.max(16, y);
        },

        nextStep() {
            if (this.currentStep < this.steps.length - 1) {
                this.currentStep++;
                this.$nextTick(() => this.renderStep());
            } else {
                this.closeTour();
            }
        },

        prevStep() {
            if (this.currentStep > 0) {
                this.currentStep--;
                this.$nextTick(() => this.renderStep());
            }
        },

        closeTour() {
            this.open = false;
            fetch('{{ route('tour.dismiss') }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
        }
    };

    if (typeof Alpine !== 'undefined') {
        Alpine.data('onboardingTour', function() { return tourData; });
    } else {
        document.addEventListener('alpine:init', function() {
            Alpine.data('onboardingTour', function() { return tourData; });
        });
    }
})();
</script>
