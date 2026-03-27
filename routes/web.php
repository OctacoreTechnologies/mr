<?php

use App\Http\Controllers\applications\ApplicationController;
use App\Http\Controllers\Categories\AcFrequencyDriveController;
use App\Http\Controllers\Categories\BatchController;
use App\Http\Controllers\Categories\BearingController;
use App\Http\Controllers\Categories\BladeController;
use App\Http\Controllers\Categories\BlowerController;
use App\Http\Controllers\Categories\CapacityController;
use App\Http\Controllers\Categories\ElectricalController;
use App\Http\Controllers\Categories\FeedingHooperCapacityController;
use App\Http\Controllers\Categories\MachineController;
use App\Http\Controllers\Categories\MachineTypeController;
use App\Http\Controllers\Categories\MakeMotorController;
use App\Http\Controllers\Categories\MaterialToProcessController;
use App\Http\Controllers\Categories\MixingToolController;
use App\Http\Controllers\Categories\ModeleController;
use App\Http\Controllers\Categories\MotorRequirementController;
use App\Http\Controllers\Categories\PneumaticController;
use App\Http\Controllers\Categories\RotaryAirLockValveController;
use App\Http\Controllers\customer\CustomerController;
use App\Http\Controllers\customer\CustomerFollowUpController;
use App\Http\Controllers\dashboard\DashBoardController;
use App\Http\Controllers\lead\LeadController;
use App\Http\Controllers\lead\LeadFollowUpController;
use App\Http\Controllers\mail\EmailController;
use App\Http\Controllers\mail\EmailController_2;
use App\Http\Controllers\mail\EmailTemplateController;
use App\Http\Controllers\mail\EmailTemplateController_2;
use App\Http\Controllers\mails\SendEmailController;
use App\Http\Controllers\notifications\NotificationController;
use App\Http\Controllers\opportunity\OpportunityController;
use App\Http\Controllers\order_acceptance_letter\OrderAccpetanceLetterController;
use App\Http\Controllers\product\ProductController;
use App\Http\Controllers\quotation\FollowupQuotationController;
use App\Http\Controllers\quotation\QuotationController;
use App\Http\Controllers\region\RegionController;
use App\Http\Controllers\remiders\ReminderController;
use App\Http\Controllers\reports\ReportCustomerController;
use App\Http\Controllers\reports\ReportLeadController;
use App\Http\Controllers\reports\ReportQuotationController;
use App\Http\Controllers\reports\ReportSaleOrderController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\RoleAndPermission\RoleController;
use App\Http\Controllers\sale_orders\AdvancePaymentLetterController;
use App\Http\Controllers\sale_orders\SaleOrderController;
use App\Http\Controllers\Term\TermConditionController;
use App\Http\Controllers\user\UserController;
use App\Models\AdvancePaymentLetter;
use App\Models\Application;
use App\Models\Customer;
use App\Models\MakeMotor;
use App\Models\MixingTool;
use App\Models\OrderAcceptanceLetter;
use App\Models\RotaryAirLockValve;
use App\Notifications\QuotationReminderNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/login');

Auth::routes();

Route::middleware(['auth'])->group(function () {

  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

  // Lead Routes
  Route::middleware(['can:view leads'])->group(function () {
    Route::resource('/lead', LeadController::class);
    Route::controller(LeadFollowUpController::class)->prefix('/lead')->group(function () {
      Route::get('/followup/edit/{leadId}', 'followUpQuotationEdit')->name('lead.followup.edit');
      Route::put('/followup/update/{leadId}', 'followUpQuotationStore')->name('lead.followup.update');
    });
  });

  // Opportunities Routes
  Route::middleware(['can:view opportunities'])->group(function () {
    Route::resource('/opportunity', OpportunityController::class);
  });

  // Quotation Routes
  Route::middleware(['can:view quotations'])->group(function () {
    Route::resource('/quotation', QuotationController::class);
    Route::get('/quotation/{id}/audits', [App\Http\Controllers\quotation\QuotationController::class, 'audits'])->name('quotation.audits');
    Route::post('/quotation/store', [QuotationController::class, 'store'])->name('q.stores');
    Route::get('/quotation/{id}/reorder', [QuotationController::class, 'reorder'])->name('quotation.reorder');
    Route::get('/quoation/preview', [QuotationController::class, 'previewForm'])->name('quotation.previewForm');
    Route::post('/quotations/previewp', [QuotationController::class, 'preview'])->name('quotation.preview');
    Route::get('/quotaion/pdf/{id}', [QuotationController::class, 'viewPdf'])->name('quotation.pdf');
    Route::post('/quotation/status', [QuotationController::class, 'updateStatus'])->name('quotation.update.status');
    Route::get('/quotation/editform/{id}', [QuotationController::class, 'full_edit'])->name('quotation.fullEditForm');
    Route::put('/quotation/fullupdate/{id}', [QuotationController::class, 'full_update'])->name('quotation.fullUpdate');
  });

  // Application Routes
  Route::middleware(['can:view applications'])->group(function () {
    Route::resource('/applications', ApplicationController::class);
  });

  // Customer Routes
  Route::middleware(['can:view customers'])->group(function () {
    Route::resource('/customer', CustomerController::class);
    Route::controller(CustomerFollowUpController::class)->prefix('/customer')->group(function () {
      Route::get('/followup/edit/{customerId}', 'CustomerfollowUpEdit')->name('followup.edit');
      Route::put('/followup/update/{customerId}', 'CustomerfollowUpStore')->name('followup.update');
      Route::get('/followup/customer/{customerId}', 'customerFollowUp')->name('followup.customers.show');
    });
    Route::post('customer/import', [CustomerController::class, 'import'])->name('customer.import');
  });

  // Terms & Conditions Routes
  Route::middleware(['can:view terms conditions'])->group(function () {
    Route::resource('term-conditions', TermConditionController::class);
  });

  // Products / Categories Routes
  Route::middleware(['can:view categories'])->group(function () {
    Route::resource('/product', ProductController::class);

    // Products / Categories Routes
    Route::middleware(['can:view categories'])->group(function () {
      Route::resource('/product', ProductController::class);

      Route::prefix('/categories')->group(function () {
        Route::controller(MachineTypeController::class)->group(function () {
          Route::get('/machine-type', 'index')->name('machine-type.index');
          Route::get('/machine-type/{id}/edit', 'edit')->name('machine-type.edit');
          Route::post('/machine-type/store', 'store')->name('machine-type.store');
          Route::put('/machine-type/update/{id}', 'update')->name('machine-type.update');
          Route::delete('/machine-type/delete/{id}', 'destroy')->name('machine-type.destroy');
          Route::get('/get-machines/{machineTypeId}', 'getMachines')->name('getmachines');
        });

        Route::controller(MachineController::class)->group(function () {
          Route::get('/machine', 'index')->name('machine.index');
          Route::get('/machine/create', 'createe')->name('machine.create');
          Route::post('/machine/store', 'store')->name('machine.store');
          Route::get('/machine/{id}/edit', 'edit')->name('machine.edit');
          Route::put('/machine/update/{id}', 'update')->name('machine.update');
          Route::delete('/machine/delete/{id}', 'destroy')->name('machine.destroy');
        });
        Route::resource('/model', ModeleController::class);
        Route::resource('/material-to-process', MaterialToProcessController::class);
        Route::resource('/batch', BatchController::class);
        Route::resource('/mixing-tool', MixingToolController::class);
        Route::resource('/motor-requirement', MotorRequirementController::class);
        Route::resource('/electrical-control', ElectricalController::class);
        Route::resource('/ac-frequency-drive', AcFrequencyDriveController::class);
        Route::resource('/bearing', BearingController::class);
        Route::resource('/pneumatic', PneumaticController::class);
        Route::resource('/make-motor', MakeMotorController::class);
        Route::resource('/capacity', CapacityController::class);
        Route::resource("/blade", BladeController::class);
        Route::resource('/blowers', BlowerController::class);
        Route::resource('/feeding_hooper_capacities', FeedingHooperCapacityController::class);
        Route::resource('/rotary-air-lock-valves', RotaryAirLockValveController::class);
        Route::get('/options/applications/{id}', [ApplicationController::class, 'applicationOptionsByMachine'])->name('application.options');
        Route::get('/options/models/{machine_id}/{application_id}', [ModeleController::class, 'getModelsByApplicationId'])->name('model.options');
      });
    });

    // Reports Routes
    Route::middleware(['can:view reports'])->group(function () {
      Route::prefix('/report')->group(function () {
        Route::controller(ReportQuotationController::class)->group(function () {
          Route::get('/quotations', 'quotationReport')->name('quotation.report');
        });

        Route::controller(ReportLeadController::class)->group(function () {
          Route::get('/leads', 'leadReport')->name('lead.report');
        });

        Route::controller(ReportCustomerController::class)->group(function () {
          Route::get('/customers', 'customerReport')->name('customer.report');
        });
        Route::controller(ReportSaleOrderController::class)->group(function () {
          Route::get('/sale-order', 'saleOrderReport')->name('saleOrder.report');
        });
      });
    });

    // Reminders Routes
    Route::middleware(['can:view reminders'])->group(function () {
      Route::controller(ReminderController::class)->group(function () {
        Route::get('/reminder/today', 'remiderToday')->name('reminder.today');
        Route::get('/reminder/read/{id}', 'readAt')->name('reminder.read');
        Route::delete('remider/destroy/{id}', 'reminderDestroy')->name('reminder.destroy');
      });
    });

    // Dashboard Routes
    Route::middleware(['can:view dashboard'])->group(function () {
      Route::controller(DashBoardController::class)->prefix('/dashboard')->group(function () {
        Route::get('/index', 'dashboard')->name('dashboard.index');
        Route::get('/users-summary', 'summary')->name('dashbord.user');
      });
    });

    // Sale Orders Routes
    Route::middleware(['can:view sale orders'])->group(function () {
      Route::resource('/sale-order', SaleOrderController::class);
      Route::get('/sale-order/{id}/account-pdf', [SaleOrderController::class, 'downloadAccountPdf'])->name('sale-order.account-pdf');
      Route::get('/sale-order/{id}/advance-pdf', [SaleOrderController::class, 'downloadAdvancePaymentPdf'])->name('sale-order.advance-pdf');
      Route::get('/sale-order/{id}/account-details', [SaleOrderController::class, 'getAccountDetails'])->name('getAccountDetails');
      Route::post('/quotation-verify', [QuotationController::class, 'isVerified'])->name('admin.quotation.verify');
      Route::prefix('sale-order/')->group(function () {
        Route::resource('/order-acceptence-letter', AdvancePaymentLetterController::class);
        Route::put('order-acceptance-update/{id}', [OrderAccpetanceLetterController::class, 'update'])->name('orderaceptance.update');
        Route::get('order-acceptance-letter/index', [OrderAccpetanceLetterController::class, 'index'])->name('orderaceptance.index');
        Route::get('order-acceptance-letter/show/{id}', [OrderAccpetanceLetterController::class, 'show'])->name('orderaceptance.show');
        Route::get('order-acceptance-letter/pdf/{id}', [OrderAccpetanceLetterController::class, 'downloadOalPdf'])->name('orderaceptance.pdf');
        Route::controller(SaleOrderController::class)->group(function () {
          Route::get('advance-payment/index', 'advanceIndex')->name('total_order_advance.index');
          Route::get('advance-payment/edit/{id}', 'advancePaymentEdit')->name('total_order_advance.index.edit');
        });
      });
    });

    // Email Routes
    Route::middleware(['can:view mails'])->group(function () {
      Route::resource('/mail', EmailController::class);
      Route::get('mail/application/{applicationId}', [EmailController::class, 'applicatonEmail']);
    });

    // Email Send Routes
    Route::middleware(['can:send emails'])->group(function () {
      Route::prefix('/email-send')->controller(SendEmailController::class)->group(function () {
        Route::post('/quotation', 'sendMail')->name('quotation.send.mail');
      });
      Route::get('/emails/send', [EmailController_2::class, 'create'])->name('emails.create');
      Route::post('/emails/send', [EmailController_2::class, 'send'])->name('emails.send');
    });

    // Email Templates Routes
    Route::middleware(['can:view email templates'])->group(function () {
      Route::resource('email-templates', EmailTemplateController::class);
      Route::post('email-templates/{emailTemplate}/preview', [EmailTemplateController::class, 'preview'])->name('email-templates.preview');
      Route::post('email-templates/{emailTemplate}/send-test', [EmailTemplateController::class, 'sendTest'])->name('email-templates.sendTest');
      Route::resource('email-template', EmailTemplateController_2::class);
    });

    // Bank Details Routes
    Route::middleware(['can:view bank details'])->group(function () {
      Route::prefix('/bank')->group(function () {
        Route::controller(App\Http\Controllers\Bank\BankDetailController::class)->group(function () {
          Route::get('/details', 'index')->name('bank.details');
          Route::post('/details/update', 'update')->name('bank.details.update');
        });
      });
    });

    // Roles & Permissions Routes
    Route::middleware(['can:view roles'])->prefix('/admin')->name('admin.')->group(function () {
      Route::resource('/role', RoleController::class);
    });

    Route::middleware(['can:view permissions'])->prefix('/admin')->name('admin.')->group(function () {
      Route::resource('/permission', PermissionController::class);
    });

    Route::middleware(['can:view users'])->prefix('/admin')->name('admin.')->group(function () {
      Route::resource('/users', UserController::class);
    });

    // Notification Routes
    Route::controller(NotificationController::class)->prefix('/notification')->group(function () {
      Route::get('/quotation-todays-count', 'countQuotationReminder');
    });

    // Customer Data Fetch Routes
    Route::get('/get-customer/{customerId}', [CustomerController::class, 'customerDetail'])->name('fetch.customer');
    Route::get('/api/customers/{id}/sale-orders', [SaleOrderController::class, 'saleOrdersByCustomer'])->name('api.customers.sale-orders');
    Route::get('/api/customers/{id}/quotations', [SaleOrderController::class, 'quotationsByCustomer'])->name('api.customers.quotations');

    // Email Helper Routes
    Route::post('/emails/fetch-recipients', [EmailController_2::class, 'fetchRecipients'])->name('emails.fetchRecipients');
    Route::get('/emails/get-template/{id}', [EmailController_2::class, 'getTemplate'])->name('emails.getTemplate');

    Route::get('/get-states/{region_id}', [RegionController::class, 'getStates']);

    Route::get('/privacy-poliyc', function () {
      return view('');
    });
  });
});
