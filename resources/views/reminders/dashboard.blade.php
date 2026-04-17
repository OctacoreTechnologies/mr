<template>
  <div class="reminder-dashboard">
    <!-- Header -->
    <div class="dashboard-header mb-6">
      <h1 class="text-3xl font-bold">Reminders Dashboard</h1>
      <p class="text-gray-600">Manage and track all customer follow-ups</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
      <!-- Pending -->
      <div class="stat-card bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
        <div class="text-sm text-gray-600 font-semibold">Pending</div>
        <div class="text-3xl font-bold text-blue-600">{{ stats.pending }}</div>
        <div class="text-xs text-gray-500 mt-1">Awaiting action</div>
      </div>

      <!-- Overdue -->
      <div class="stat-card bg-red-50 border-l-4 border-red-500 p-4 rounded">
        <div class="text-sm text-gray-600 font-semibold">Overdue</div>
        <div class="text-3xl font-bold text-red-600">{{ stats.overdue }}</div>
        <div class="text-xs text-gray-500 mt-1">Requires attention</div>
      </div>

      <!-- Upcoming (7 days) -->
      <div class="stat-card bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
        <div class="text-sm text-gray-600 font-semibold">Upcoming</div>
        <div class="text-3xl font-bold text-yellow-600">{{ stats.upcoming }}</div>
        <div class="text-xs text-gray-500 mt-1">Next 7 days</div>
      </div>

      <!-- High Priority -->
      <div class="stat-card bg-orange-50 border-l-4 border-orange-500 p-4 rounded">
        <div class="text-sm text-gray-600 font-semibold">High Priority</div>
        <div class="text-3xl font-bold text-orange-600">{{ stats.high_priority }}</div>
        <div class="text-xs text-gray-500 mt-1">Urgent actions</div>
      </div>

      <!-- Completed Today -->
      <div class="stat-card bg-green-50 border-l-4 border-green-500 p-4 rounded">
        <div class="text-sm text-gray-600 font-semibold">Completed Today</div>
        <div class="text-3xl font-bold text-green-600">{{ stats.completed_today }}</div>
        <div class="text-xs text-gray-500 mt-1">Great work!</div>
      </div>
    </div>

    <!-- Tabs -->
    <div class="tabs mb-6">
      <div class="tab-buttons flex gap-2 border-b border-gray-200">
        <button 
          v-for="tab in tabs" 
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="['px-4 py-2 font-semibold border-b-2 transition', 
            activeTab === tab.id 
              ? 'border-blue-500 text-blue-600' 
              : 'border-transparent text-gray-600 hover:text-blue-500']"
        >
          {{ tab.label }}
        </button>
      </div>
    </div>

    <!-- Reminders List -->
    <div class="reminders-section bg-white rounded-lg shadow">
      <!-- Filters -->
      <div class="filter-bar p-4 border-b border-gray-200 flex flex-wrap gap-3">
        <input 
          v-model="filters.search" 
          type="text" 
          placeholder="Search by customer name..." 
          class="px-3 py-2 border rounded"
        />
        <select 
          v-model="filters.type" 
          class="px-3 py-2 border rounded"
        >
          <option value="">All Types</option>
          <option value="lead_followup">Lead Follow-up</option>
          <option value="opportunity_followup">Opportunity Follow-up</option>
          <option value="quotation_followup">Quotation Follow-up</option>
        </select>
        <select 
          v-model="filters.priority" 
          class="px-3 py-2 border rounded"
        >
          <option value="">All Priorities</option>
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
          <option value="urgent">Urgent</option>
        </select>
        <button 
          @click="applyFilters"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          Apply Filters
        </button>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Message</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Due Date</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Priority</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr 
              v-for="reminder in filteredReminders" 
              :key="reminder.id"
              class="border-b hover:bg-gray-50 cursor-pointer"
              @click="selectReminder(reminder)"
            >
              <td class="px-6 py-4 text-sm font-medium">{{ reminder.customer.name }}</td>
              <td class="px-6 py-4 text-sm">
                <span :class="['px-2 py-1 rounded text-xs font-semibold', getTypeClass(reminder.reminder_type)]">
                  {{ formatType(reminder.reminder_type) }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ truncate(reminder.reminder_message, 50) }}</td>
              <td class="px-6 py-4 text-sm">
                <span :class="isOverdue(reminder) ? 'text-red-600 font-semibold' : ''">
                  {{ formatDate(reminder.reminder_date) }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm">
                <span :class="['px-2 py-1 rounded text-xs font-semibold', getPriorityClass(reminder.priority)]">
                  {{ reminder.priority }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm">
                <span :class="['px-2 py-1 rounded text-xs font-semibold', getStatusClass(reminder.status)]">
                  {{ reminder.status }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm" @click.stop>
                <div class="flex gap-2">
                  <button 
                    @click="openReminderDetail(reminder)"
                    class="text-blue-600 hover:text-blue-800"
                    title="View Details"
                  >
                    <i class="fas fa-eye"></i>
                  </button>
                  <button 
                    v-if="reminder.status === 'pending'"
                    @click="snoozeReminder(reminder)"
                    class="text-yellow-600 hover:text-yellow-800"
                    title="Snooze"
                  >
                    <i class="fas fa-clock"></i>
                  </button>
                  <button 
                    @click="completeReminder(reminder)"
                    class="text-green-600 hover:text-green-800"
                    title="Complete"
                  >
                    <i class="fas fa-check"></i>
                  </button>
                  <button 
                    @click="deleteReminder(reminder)"
                    class="text-red-600 hover:text-red-800"
                    title="Delete"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Empty State -->
      <div 
        v-if="filteredReminders.length === 0" 
        class="p-8 text-center text-gray-500"
      >
        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
        <p>No reminders found</p>
      </div>
    </div>

    <!-- Reminder Detail Modal -->
    <div 
      v-if="selectedReminder" 
      class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      @click="selectedReminder = null"
    >
      <div class="modal-content bg-white rounded-lg shadow-lg max-w-2xl w-full mx-4" @click.stop>
        <div class="modal-header p-6 border-b border-gray-200 flex justify-between items-center">
          <h2 class="text-xl font-bold">Reminder Details</h2>
          <button 
            @click="selectedReminder = null"
            class="text-gray-500 hover:text-gray-700"
          >
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div class="modal-body p-6">
          <!-- Customer Info -->
          <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3">Customer Information</h3>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <p class="text-gray-600 text-sm">Name</p>
                <p class="font-semibold">{{ selectedReminder.customer.name }}</p>
              </div>
              <div>
                <p class="text-gray-600 text-sm">Email</p>
                <p class="font-semibold">{{ selectedReminder.customer.email }}</p>
              </div>
              <div>
                <p class="text-gray-600 text-sm">Phone</p>
                <p class="font-semibold">{{ selectedReminder.customer.phone }}</p>
              </div>
              <div>
                <p class="text-gray-600 text-sm">Company</p>
                <p class="font-semibold">{{ selectedReminder.customer.company_name }}</p>
              </div>
            </div>
          </div>

          <!-- Reminder Info -->
          <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3">Reminder Information</h3>
            <div class="bg-gray-50 p-4 rounded">
              <p class="text-sm text-gray-600 mb-2">Message</p>
              <p class="mb-4">{{ selectedReminder.reminder_message }}</p>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="text-sm text-gray-600">Due Date</p>
                  <p class="font-semibold">{{ formatDate(selectedReminder.reminder_date) }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-600">Status</p>
                  <span :class="['px-2 py-1 rounded text-xs font-semibold inline-block', getStatusClass(selectedReminder.status)]">
                    {{ selectedReminder.status }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Customer Journey -->
          <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3">Customer Journey</h3>
            <div class="space-y-2">
              <div 
                v-for="(step, index) in selectedReminder.customer_journey" 
                :key="index"
                class="flex items-center"
              >
                <div class="w-32">
                  <span class="font-semibold text-sm">{{ step.type }}</span>
                </div>
                <div class="flex-1 border-t border-gray-300 mx-2"></div>
                <div class="text-sm text-gray-600">{{ formatDate(step.date) }}</div>
              </div>
            </div>
          </div>

          <!-- Activity Log -->
          <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3">Activity Log</h3>
            <div class="space-y-2 max-h-64 overflow-y-auto">
              <div 
                v-for="log in selectedReminder.logs" 
                :key="log.id"
                class="flex items-start p-3 bg-gray-50 rounded text-sm"
              >
                <div class="flex-1">
                  <p class="font-semibold capitalize">{{ log.action }}</p>
                  <p class="text-gray-600 text-xs">{{ formatDate(log.created_at) }}</p>
                  <p v-if="log.error_message" class="text-red-600 text-xs">{{ log.error_message }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Actions -->
        <div class="modal-footer p-6 border-t border-gray-200 flex gap-2 justify-end">
          <button 
            @click="selectedReminder = null"
            class="px-4 py-2 border rounded hover:bg-gray-50"
          >
            Close
          </button>
          <button 
            v-if="selectedReminder.status === 'pending'"
            @click="completeReminder(selectedReminder)"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
          >
            Complete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

export default {
  name: 'ReminderDashboard',
  setup() {
    const activeTab = ref('all');
    const selectedReminder = ref(null);
    const reminders = ref([]);
    const stats = ref({
      pending: 0,
      overdue: 0,
      upcoming: 0,
      high_priority: 0,
      completed_today: 0,
    });
    const filters = ref({
      search: '',
      type: '',
      priority: '',
    });

    const tabs = [
      { id: 'all', label: 'All Reminders' },
      { id: 'pending', label: 'Pending' },
      { id: 'overdue', label: 'Overdue' },
      { id: 'upcoming', label: 'Upcoming' },
      { id: 'high_priority', label: 'High Priority' },
    ];

    // Load dashboard data
    const loadDashboard = async () => {
      try {
        const response = await axios.get('/api/reminders/dashboard');
        stats.value = response.data.stats;
        reminders.value = response.data.pending_reminders;
      } catch (error) {
        console.error('Error loading dashboard:', error);
      }
    };

    // Filter reminders based on active tab
    const filteredReminders = computed(() => {
      let filtered = reminders.value;

      // Filter by tab
      if (activeTab.value === 'pending') {
        filtered = filtered.filter(r => r.status === 'pending');
      } else if (activeTab.value === 'overdue') {
        filtered = filtered.filter(r => new Date(r.reminder_date) < new Date() && r.status === 'pending');
      } else if (activeTab.value === 'upcoming') {
        filtered = filtered.filter(r => {
          const date = new Date(r.reminder_date);
          const now = new Date();
          const sevenDaysFromNow = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);
          return date >= now && date <= sevenDaysFromNow && r.status === 'pending';
        });
      } else if (activeTab.value === 'high_priority') {
        filtered = filtered.filter(r => ['high', 'urgent'].includes(r.priority) && r.status === 'pending');
      }

      // Filter by search and dropdowns
      if (filters.value.search) {
        filtered = filtered.filter(r => 
          r.customer.name.toLowerCase().includes(filters.value.search.toLowerCase())
        );
      }
      if (filters.value.type) {
        filtered = filtered.filter(r => r.reminder_type === filters.value.type);
      }
      if (filters.value.priority) {
        filtered = filtered.filter(r => r.priority === filters.value.priority);
      }

      return filtered;
    });

    // Utility functions
    const formatDate = (date) => {
      return new Date(date).toLocaleDateString('en-GB', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
      });
    };

    const formatType = (type) => {
      const types = {
        lead_followup: 'Lead Follow-up',
        opportunity_followup: 'Opportunity Follow-up',
        quotation_followup: 'Quotation Follow-up',
      };
      return types[type] || type;
    };

    const truncate = (text, length) => {
      return text.length > length ? text.substring(0, length) + '...' : text;
    };

    const isOverdue = (reminder) => {
      return new Date(reminder.reminder_date) < new Date() && reminder.status === 'pending';
    };

    const getTypeClass = (type) => {
      const classes = {
        lead_followup: 'bg-blue-100 text-blue-800',
        opportunity_followup: 'bg-purple-100 text-purple-800',
        quotation_followup: 'bg-green-100 text-green-800',
      };
      return classes[type] || 'bg-gray-100 text-gray-800';
    };

    const getPriorityClass = (priority) => {
      const classes = {
        low: 'bg-gray-100 text-gray-800',
        medium: 'bg-blue-100 text-blue-800',
        high: 'bg-orange-100 text-orange-800',
        urgent: 'bg-red-100 text-red-800',
      };
      return classes[priority] || 'bg-gray-100 text-gray-800';
    };

    const getStatusClass = (status) => {
      const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        sent: 'bg-blue-100 text-blue-800',
        viewed: 'bg-purple-100 text-purple-800',
        completed: 'bg-green-100 text-green-800',
        snoozed: 'bg-gray-100 text-gray-800',
      };
      return classes[status] || 'bg-gray-100 text-gray-800';
    };

    // Actions
    const openReminderDetail = async (reminder) => {
      try {
        const response = await axios.get(`/api/reminders/${reminder.id}`);
        selectedReminder.value = response.data.reminder;
      } catch (error) {
        console.error('Error loading reminder details:', error);
      }
    };

    const completeReminder = async (reminder) => {
      try {
        await axios.post(`/api/reminders/${reminder.id}/mark-completed`);
        reminder.status = 'completed';
        alert('Reminder marked as completed!');
      } catch (error) {
        console.error('Error completing reminder:', error);
      }
    };

    const snoozeReminder = async (reminder) => {
      const minutes = prompt('Snooze for how many minutes? (5-1440)', '60');
      if (minutes && !isNaN(minutes)) {
        try {
          await axios.post(`/api/reminders/${reminder.id}/snooze`, { minutes: parseInt(minutes) });
          reminder.status = 'snoozed';
          alert('Reminder snoozed!');
        } catch (error) {
          console.error('Error snoozing reminder:', error);
        }
      }
    };

    const deleteReminder = async (reminder) => {
      if (confirm('Are you sure you want to delete this reminder?')) {
        try {
          await axios.delete(`/api/reminders/${reminder.id}`);
          reminders.value = reminders.value.filter(r => r.id !== reminder.id);
          alert('Reminder deleted!');
        } catch (error) {
          console.error('Error deleting reminder:', error);
        }
      }
    };

    const selectReminder = (reminder) => {
      openReminderDetail(reminder);
    };

    const applyFilters = () => {
      // Filters are applied via computed property
    };

    onMounted(() => {
      loadDashboard();
      // Refresh dashboard every 30 seconds
      setInterval(loadDashboard, 30000);
    });

    return {
      activeTab,
      selectedReminder,
      reminders,
      stats,
      filters,
      tabs,
      filteredReminders,
      formatDate,
      formatType,
      truncate,
      isOverdue,
      getTypeClass,
      getPriorityClass,
      getStatusClass,
      openReminderDetail,
      completeReminder,
      snoozeReminder,
      deleteReminder,
      selectReminder,
      applyFilters,
    };
  },
};
</script>

<style scoped>
.reminder-dashboard {
  padding: 2rem;
}

.stat-card {
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.modal-overlay {
  animation: fadeIn 0.2s ease-in-out;
}

.modal-content {
  animation: slideUp 0.3s ease-in-out;
  max-height: 90vh;
  overflow-y-auto;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    transform: translateY(20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

table tbody tr {
  transition: background-color 0.2s ease;
}
</style>