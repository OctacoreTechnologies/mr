<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  EmailTemplate::create([
        //     'name' => 'Welcome Email',
        //     'subject' => 'Welcome to Our CRM, {{name}}!',
        //     'body' => '<p>Hi {{name}},</p><p>Thank you for joining us. We are excited to have you on board!</p><p>Best regards,<br>CRM Team</p>',
        //     'variables' => json_encode(['name']),
        //     'status' => 'active',
        //     'created_by' => 1,
        // ]);

        // EmailTemplate::create([
        //     'name' => 'Deal Follow-up',
        //     'subject' => 'Your Deal is Progressing, {{name}}',
        //     'body' => '<p>Hello {{name}},</p><p>Your deal worth {{deal_amount}} is currently in progress. Please contact us for more details.</p>',
        //     'variables' => json_encode(['name','deal_amount']),
        //     'status' => 'active',
        //     'created_by' => 1,
        // ]);

        // EmailTemplate::create([
        //     'name' => 'Invoice Sent',
        //     'subject' => 'Invoice #{{invoice_number}} for {{name}}',
        //     'body' => '<p>Hi {{name}},</p><p>Your invoice #{{invoice_number}} of amount {{amount}} has been generated.</p><p>Thank you for your business.</p>',
        //     'variables' => json_encode(['name','invoice_number','amount']),
        //     'status' => 'active',
        //     'created_by' => 1,
        // ]);

         EmailTemplate::create([
            'name' => 'Full CKEditor Demo',
            'subject' => 'Welcome {{name}} to Our CRM!',
            'body' => '
<h2 style="color:#1E90FF;">Hello {{name}},</h2>
<p>We are excited to have you on board! Here’s a quick guide to get started:</p>

<h4>1. Features Overview</h4>
<ul>
    <li><strong>Dashboard:</strong> View your activities at a glance</li>
    <li><em>Contacts:</em> Manage your leads and clients</li>
    <li>Reports and Analytics to track performance</li>
</ul>

<h4>2. Quick Tips</h4>
<ol>
    <li>Use <u>search</u> to find any contact quickly</li>
    <li>Create new deals directly from the dashboard</li>
    <li>Use the <strong>email templates</strong> to send professional emails</li>
</ol>

<h4>3. Sample Table</h4>
<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
    <tr style="background:#f2f2f2;">
        <th>Feature</th>
        <th>Description</th>
        <th>Status</th>
    </tr>
    <tr>
        <td>Dashboard</td>
        <td>Overview of all activities</td>
        <td>Active</td>
    </tr>
    <tr>
        <td>Contacts</td>
        <td>Manage leads and clients</td>
        <td>Active</td>
    </tr>
    <tr>
        <td>Reports</td>
        <td>View analytics</td>
        <td>Coming Soon</td>
    </tr>
</table>

<h4>4. Links & Images</h4>
<p>Visit our <a href="https://example.com" target="_blank">website</a> for more info.</p>
<p><img src="https://via.placeholder.com/300x100.png?text=CRM+Demo+Image" alt="Demo Image"></p>

<p>Best regards,<br><strong>CRM Team</strong></p>
',
            'variables' => json_encode(['name']),
            'status' => 'active',
            'created_by' => 1,
        ]);
    }

}
