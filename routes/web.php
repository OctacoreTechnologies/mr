<?php

use App\Http\Controllers\applications\ApplicationController;
use App\Http\Controllers\Bank\BankDetailController;
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
use App\Http\Controllers\HomeController;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Redirect root to login
Route::redirect('/', '/login');

// Authentication Routes
Auth::routes();

// Debug Route (Only for Testing - Remove in Production)
Route::get('/debug', function () {
    return [
        'roles' => Auth::user()?->getRoleNames(),
        'permissions' => Auth::user()?->getAllPermissions()->pluck('name'),
    ];
})->middleware('auth');

// Privacy Policy Route
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES GROUP
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ========== HOME ROUTE ==========
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ========== LEAD MANAGEMENT ==========
    Route::middleware(['can:lead_view'])->group(function () {
        Route::resource('/lead', LeadController::class);

        Route::controller(LeadFollowUpController::class)
            ->prefix('/lead/followup')
            ->group(function () {
                Route::get('/edit/{leadId}', 'followUpQuotationEdit')->name('lead.followup.edit');
                Route::put('/update/{leadId}', 'followUpQuotationStore')->name('lead.followup.update');
            });
    });

    // ========== OPPORTUNITY MANAGEMENT ==========
    Route::middleware(['can:opportunity_view'])->group(function () {
        Route::resource('/opportunity', OpportunityController::class);
    });

    // ========== QUOTATION MANAGEMENT ==========
    Route::middleware(['can:quotation_view'])->group(function () {

        Route::controller(QuotationController::class)
            ->prefix('/quotation')
            ->group(function () {
                Route::post('/store', 'store')->name('quotation.store');
                Route::get('/previewform', 'previewForm')->name('quotation.previewForm');
                Route::post('/preview', 'preview')->name('quotation.preview');
                Route::post('/status', 'updateStatus')->name('quotation.update.status');

                // Routes WITH {id} parameter (MUST come last!)
                Route::get('/{id}/audits', 'audits')->name('quotation.audits');
                Route::get('/{id}/reorder', 'reorder')->name('quotation.reorder');
                Route::get('/{id}/pdf', 'viewPdf')->name('quotation.pdf');
                Route::get('/{id}/edit-form', 'full_edit')->name('quotation.fullEditForm');
                Route::put('/{id}/full-update', 'full_update')->name('quotation.fullUpdate');
            });
        Route::resource('/quotation', QuotationController::class);

        // Quotation Verification (used in sale orders)
        Route::post('admin/quotation-verify', [QuotationController::class, 'isVerified'])
            ->name('admin.quotation.verify');
    });

    // ========== APPLICATION MANAGEMENT ==========
    Route::middleware(['can:application_view'])->group(function () {
        Route::resource('/applications', ApplicationController::class);
    });

    // ========== CUSTOMER MANAGEMENT ==========
    Route::middleware(['can:customer_view'])->group(function () {
        Route::resource('/customer', CustomerController::class);

        Route::controller(CustomerFollowUpController::class)
            ->prefix('/customer')
            ->group(function () {
                Route::get('/followup/edit/{customerId}', 'CustomerfollowUpEdit')
                    ->name('followup.edit');
                Route::put('/followup/update/{customerId}', 'CustomerfollowUpStore')
                    ->name('followup.update');
                Route::get('/followup/show/{customerId}', 'customerFollowUp')
                    ->name('followup.customers.show');
                Route::delete('/followup-document/{docId}', 'deleteDocument')
                    ->name('followup.document.delete');

                // Customer follow-up list view
                Route::get('/customer/{customerId}/followup', 'customerFollowUp')
                    ->name('followup.show');
            });

        Route::post('/import', [CustomerController::class, 'import'])
            ->name('customer.import');

        Route::get('/excel-sample', [CustomerController::class, 'getCustomerExcelSample'])
            ->name('customer.excel.sample');
    });

    // ========== TERMS & CONDITIONS ==========
    Route::middleware(['can:terms_view'])->group(function () {
        Route::resource('/term-conditions', TermConditionController::class);
    });

    // ========== PRODUCTS & CATEGORIES ==========
    Route::middleware(['can:category_view'])->group(function () {

        Route::resource('/product', ProductController::class);

        // ===== CATEGORY ROUTES =====
        Route::prefix('/categories')->group(function () {

            // Machine Type Category
            Route::controller(MachineTypeController::class)
                ->prefix('/machine-type')
                ->group(function () {
                    Route::get('/', 'index')->name('machine-type.index');
                    Route::get('/{id}/edit', 'edit')->name('machine-type.edit');
                    Route::post('/store', 'store')->name('machine-type.store');
                    Route::put('/{id}/update', 'update')->name('machine-type.update');
                    Route::delete('/{id}/delete', 'destroy')->name('machine-type.destroy');
                    Route::get('/get-machines/{machineTypeId}', 'getMachines')->name('getmachines');
                });

            // Machine Category
            Route::controller(MachineController::class)
                ->prefix('/machine')
                ->group(function () {
                    Route::get('/', 'index')->name('machine.index');
                    Route::get('/create', 'createe')->name('machine.create');
                    Route::post('/store', 'store')->name('machine.store');
                    Route::get('/{id}/edit', 'edit')->name('machine.edit');
                    Route::put('/{id}/update', 'update')->name('machine.update');
                    Route::delete('/{id}/delete', 'destroy')->name('machine.destroy');
                });

            // Model Category
            Route::resource('/model', ModeleController::class);

            // Material to Process Category
            Route::resource('/material-to-process', MaterialToProcessController::class);

            // Batch Category
            Route::resource('/batch', BatchController::class);

            // Mixing Tool Category
            Route::resource('/mixing-tool', MixingToolController::class);

            // Motor Requirement Category
            Route::resource('/motor-requirement', MotorRequirementController::class);

            // Electrical Control Category
            Route::resource('/electrical-control', ElectricalController::class);

            // AC Frequency Drive Category
            Route::resource('/ac-frequency-drive', AcFrequencyDriveController::class);

            // Bearing Category
            Route::resource('/bearing', BearingController::class);

            // Pneumatic Category
            Route::resource('/pneumatic', PneumaticController::class);

            // Motor Make Category
            Route::resource('/make-motor', MakeMotorController::class);

            // Capacity Category
            Route::resource('/capacity', CapacityController::class);

            // Blade Category
            Route::resource('/blade', BladeController::class);

            // Blower Category
            Route::resource('/blowers', BlowerController::class);

            // Feeding Hooper Capacity Category
            Route::resource('/feeding_hooper_capacities', FeedingHooperCapacityController::class);

            // Rotary Air Lock Valve Category
            Route::resource('/rotary-air-lock-valves', RotaryAirLockValveController::class);

            // ===== AJAX OPTION ROUTES =====
            Route::controller(ApplicationController::class)
                ->prefix('/options')
                ->group(function () {
                    Route::get('/applications/{id}', 'applicationOptionsByMachine')
                        ->name('application.options');
                });

            Route::controller(ModeleController::class)
                ->prefix('/options')
                ->group(function () {
                    Route::get('/models/{id}', 'getModelsByMachineId')
                        ->name('model.options');
                    Route::get('/models/application/{machine_id}/{application_id}', 'getModelsByApplicationId')
                        ->name('model.options.byApplication');
                });
        });
    });

    // ========== REPORTS ==========
    Route::middleware(['can:report_view'])->group(function () {
        Route::prefix('/report')->group(function () {

            Route::controller(ReportQuotationController::class)
                ->group(function () {
                    Route::get('/quotations', 'quotationReport')->name('quotation.report');
                });

            Route::controller(ReportLeadController::class)
                ->group(function () {
                    Route::get('/leads', 'leadReport')->name('lead.report');
                });

            Route::controller(ReportCustomerController::class)
                ->group(function () {
                    Route::get('/customers', 'customerReport')->name('customer.report');
                });

            Route::controller(ReportSaleOrderController::class)
                ->group(function () {
                    Route::get('/sale-order', 'saleOrderReport')->name('saleOrder.report');
                });
        });
    });

    // ========== REMINDERS ==========
    Route::middleware(['can:reminder_view'])->group(function () {
        Route::controller(ReminderController::class)
            ->prefix('/reminder')
            ->group(function () {
                Route::get('/today', 'remiderToday')->name('reminder.today');
                Route::get('/read/{id}', 'readAt')->name('reminder.read');
                Route::delete('/{id}/destroy', 'reminderDestroy')->name('reminder.destroy');
            });
    });

    // ========== NOTIFICATIONS ==========
    Route::controller(NotificationController::class)
        ->prefix('/notification')
        ->group(function () {
            Route::get('/quotation-todays-count', 'countQuotationReminder')
                ->middleware('can:quotation_view')
                ->name('notification.quotationReminder');
        });

    // ========== DASHBOARD ==========
    Route::middleware(['can:dashboard_view'])->group(function () {
        Route::controller(DashBoardController::class)
            ->prefix('/dashboard')
            ->group(function () {
                Route::get('/index', 'dashboard')->name('dashboard.index');
                Route::get('/users-summary', 'summary')->name('dashboard.userSummary');
            });
    });

    // ========== SALE ORDERS ==========
    Route::middleware(['can:sale_order_view'])->group(function () {


        Route::controller(SaleOrderController::class)
            ->prefix('/sale-order')
            ->group(function () {
                Route::get('/{id}/account-pdf', 'downloadAccountPdf')
                    ->name('sale-order.accountPdf');
                Route::get('/{id}/advance-pdf', 'downloadAdvancePaymentPdf')
                    ->name('sale-order.advancePdf');
                Route::get('/{id}/account-details', 'getAccountDetails')
                    ->name('sale-order.accountDetails');
            });

        // Order Acceptance Letter Routes
        Route::resource('sale-order/order-acceptance-letter', OrderAccpetanceLetterController::class);

        Route::controller(OrderAccpetanceLetterController::class)
            ->prefix('/order-acceptance-letter')
            ->group(function () {
                Route::put('/{id}/update', 'update')->name('orderAcceptance.update');
                Route::get('/{id}/pdf', 'downloadOalPdf')->name('orderAcceptance.pdf');
            });

        // Advance Payment Routes
        Route::controller(SaleOrderController::class)
            ->prefix('sale-order/advance-payment')
            ->group(function () {
                Route::get('/', 'advanceIndex')->name('advancePayment.index');
                Route::get('/{id}/edit', 'advancePaymentEdit')->name('advancePayment.edit');
            });
        Route::resource('/sale-order', SaleOrderController::class);
    });

    // ========== EMAIL MANAGEMENT ==========
    Route::middleware(['can:mail_view'])->group(function () {
        Route::resource('/mail', EmailController::class);

        Route::controller(EmailController::class)
            ->prefix('/mail')
            ->group(function () {
                Route::get('/application/{applicationId}', 'applicatonEmail')
                    ->name('mail.application');
            });
    });

    // ========== EMAIL SENDING ==========
    Route::middleware(['can:mail_send'])->group(function () {

        Route::controller(SendEmailController::class)
            ->prefix('/email-send')
            ->group(function () {
                Route::post('/quotation', 'sendMail')->name('quotation.send.mail');
            });

        Route::controller(EmailController_2::class)
            ->prefix('/emails')
            ->group(function () {
                Route::get('/send', 'create')->name('emails.create');
                Route::post('/send', 'send')->name('emails.send');
                Route::post('/fetch-recipients', 'fetchRecipients')->name('emails.fetchRecipients');
                Route::get('/get-template/{id}', 'getTemplate')->name('emails.getTemplate');
            });
    });

    // ========== EMAIL TEMPLATES ==========
    Route::middleware(['can:email_template_view'])->group(function () {

        Route::resource('/email-templates', EmailTemplateController::class);

        Route::controller(EmailTemplateController::class)
            ->prefix('/email-templates')
            ->group(function () {
                Route::post('/{emailTemplate}/preview', 'preview')
                    ->name('email-templates.preview');
                Route::post('/{emailTemplate}/send-test', 'sendTest')
                    ->name('email-templates.sendTest');
            });

        Route::resource('/email-template', EmailTemplateController_2::class);
    });

    // ========== BANK DETAILS ==========
    Route::middleware(['can:bank_view'])->group(function () {
        Route::controller(BankDetailController::class)
            ->prefix('/bank')
            ->group(function () {
                Route::get('/details', 'index')->name('bank.details');
                Route::post('/details/update', 'update')->name('bank.details.update');
            });
    });

    // ========== ROLES & PERMISSIONS (Admin Panel) ==========
    Route::prefix('/admin')
        ->name('admin.')
        ->group(function () {

            // Roles Management
            Route::middleware(['can:role_view'])->group(function () {
                Route::resource('/role', RoleController::class);
            });

            // Permissions Management
            Route::middleware(['can:permission_view'])->group(function () {
                Route::resource('/permission', PermissionController::class);
            });

            // Users Management
            Route::middleware(['can:user_view'])->group(function () {
                Route::resource('/users', UserController::class);
            });
        });

    // ========== REGIONS & STATES (AJAX) ==========
    Route::controller(RegionController::class)
        ->group(function () {
            Route::get('/get-states/{region_id}', 'getStates')->name('api.getStates');
        });

    // ========== CUSTOMER DATA FETCHING (AJAX) ==========
    Route::controller(CustomerController::class)
        ->prefix('/api')
        ->group(function () {
            Route::get('/customers/{customerId}', 'customerDetail')
                ->name('api.customer.detail');
        });

    // ========== SALE ORDERS DATA FETCHING (AJAX) ==========
    Route::controller(SaleOrderController::class)
        ->prefix('/api')
        ->group(function () {
            Route::get('/customers/{id}/sale-orders', 'saleOrdersByCustomer')
                ->name('api.customers.saleOrders');
            Route::get('/customers/{id}/quotations', 'quotationsByCustomer')
                ->name('api.customers.quotations');
        });
});

/*
|--------------------------------------------------------------------------
| NOTES FOR DEVELOPERS
|--------------------------------------------------------------------------
|
| 1. PERMISSION HANDLING:
|    - Use 'can:permission_name' middleware directly in route groups
|    - This replaces nested routes and prevents 403 errors
|    - Ensure permissions are properly defined in database
|
| 2. ROUTE NAMING CONVENTIONS:
|    - Use dot notation for nested resources: 'customer.followup.edit'
|    - Use snake_case for route names
|    - Use kebab-case for URL segments
|
| 3. API ROUTES:
|    - All AJAX/API data fetching routes are prefixed with '/api'
|    - These should NOT have authentication restrictions beyond 'auth'
|    - Add specific 'can:' middleware only if needed
|
| 4. COMMON ISSUES & FIXES:
|    - 403 Error: Check user has proper role + permission assigned
|    - Route not found: Verify route name and HTTP method
|    - Permission denied: Check permission middleware spelling
|
| 5. TESTING PERMISSIONS:
|    - Use /debug endpoint to see user roles & permissions
|    - Verify permission names match route middleware
|    - Check RoleHasPermissions table in database
|
*/