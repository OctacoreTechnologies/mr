@extends('layouts.app')
@section('title','Send Email')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--multiple {
    border-radius: 8px;
    padding: 5px;
}
.card { border-radius: 12px; box-shadow:0 6px 18px rgba(0,0,0,0.05);}
</style>
@endsection

@section('content')
<div class="container py-4">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Send Email</h5>
        </div>

        <form method="POST" action="{{ route('emails.send') }}">
            @csrf
            <div class="card-body">

                <!-- Module -->
                <div class="mb-3">
                    <label class="form-label">Module</label>
                    <select id="moduleSelect" class="form-control">
                        <option value="">Custom / Manual Emails</option>
                        <option value="lead">Lead</option>
                        <option value="customer">Customer</option>
                    </select>
                </div>

                <!-- Recipients To -->

                <div class="col-md-6 form-group form-group-position">
                            <label>Recipients (To)</label>
                            <select class="form-control select2" id="recipients" name="recipients[]" multiple="multiple">
    
                            </select>
                    
                </div>

                <!-- Recipients CC -->
                <div class="mb-3">
                    <label>CC</label>
                     <select class="form-control select2" id="cc" name="cc[]" multiple="multiple"></select>
                  
                </div>

                <!-- Template -->
                <div class="mb-3">
                    <label>Email Template</label>
                    <select id="templateSelect" class="form-control">
                        <option value="">Select Template</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subject -->
                <div class="mb-3">
                    <label>Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control">
                </div>

                <!-- Body -->
                <div class="mb-3">
                    <label>Body</label>
                    <textarea name="body" id="editor" rows="8" class="form-control"></textarea>
                </div>

                <div id="placeholders" class="mb-3"></div>

            </div>

            <div class="card-footer text-end">
                <button class="btn btn-success">Send Email</button>
            </div>
        </form>
    </div>
</div>

@endsection


@push('js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace('editor',{height:300});

// Initialize Select2
$('#recipients, #cc').select2({
    tags:true,
    tokenSeparators: [',',';'],
    width:'100%'
});

// Module change -> fetch recipients dynamically
$('#moduleSelect').on('change',function(){
    let module = $(this).val();
    if(!module) return;

    fetch('{{ route("emails.fetchRecipients") }}',{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Content-Type':'application/json'
        },
        body: JSON.stringify({type:module})
    })
    .then(res=>res.json())
    .then(data=>{
        let rec = [];
        let cc = [];

        data.forEach(item=>{
            if(module=='lead'){
                rec.push({id:item.email,text:item.full_name+' <'+item.email+'>'});
            } else if(module=='customer'){
                rec.push({id:item.contact_person_1_email,text:item.company_name+' <'+item.contact_person_1_email+'>'});
                // Add secondary emails to CC
                ['contact_person_2_email','contact_person_3_email','contact_person_4_email','contact_person_5_email','contact_person_6_email']
                .forEach(k=>{
                    if(item[k]) cc.push({id:item[k],text:item[k]});
                });
            }
        });

        // Clear and load new data
        let r = $('#recipients');
        r.empty();
        rec.forEach(o=>{ let option = new Option(o.text,o.id,true,true); r.append(option); });
        
        r.trigger('change');

        let c = $('#cc');
        c.empty();
        cc.forEach(o=>{ let option = new Option(o.text,o.id,true,true); c.append(option); });
        c.trigger('change');
    });
});

// Template change -> load subject + body
$('#templateSelect').on('change',function(){
    let id = $(this).val(); if(!id) return;
    fetch('/emails/get-template/'+id)
    .then(res=>res.json())
    .then(data=>{
        $('#subject').val(data.subject);
        CKEDITOR.instances.editor.setData(data.body);

        // Extract placeholders
        // let placeholdersDiv = $('#placeholders'); placeholdersDiv.html('');
        let matches = data.body.match(/\{\{\s*[\w]+\s*\}\}/g)||[];
        matches.forEach(ph=>{
            let key = ph.replace(/\{\{|\}\}/g,'').trim();
            // placeholdersDiv.append(`<div class="mb-2">
            //     <label>${key}</label>
            //     <input type="text" name="placeholders[${key}]" class="form-control">
            // </div>`);
        });
    });
});
</script>
@endpush