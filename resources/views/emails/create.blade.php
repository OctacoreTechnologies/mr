@extends('layouts.app')
@section('title','Send Email')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--multiple {
    border-radius: 8px;
    padding: 5px;
}
.card { 
    border-radius: 12px; 
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}
</style>
@endsection

@section('content')
<div class="container py-4">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Send Email</h5>
        </div>

        <form method="POST" action="{{ route('emails.send') }}">
            @csrf

            <div class="card-body">

                <!-- Module -->
                <div class="mb-3">
                    <label>Module</label>
                    <select id="moduleSelect" name="module" class="form-control">
                        <option value="">Custom / Manual Emails</option>
                        <option value="lead" {{ old('module')=='lead'?'selected':'' }}>Lead</option>
                        <option value="customer" {{ old('module')=='customer'?'selected':'' }}>Customer</option>
                    </select>
                </div>

                <!-- Recipients -->
                <div class="mb-3">
                    <label>Recipients (To)</label>
                    <select class="form-control select2" id="recipients" name="recipients[]" multiple>
                        @if(old('recipients'))
                            @foreach(old('recipients') as $email)
                                <option value="{{ $email }}" selected>{{ $email }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- CC -->
                <div class="mb-3">
                    <label>CC</label>
                    <select class="form-control select2" id="cc" name="cc[]" multiple>
                        @if(old('cc'))
                            @foreach(old('cc') as $email)
                                <option value="{{ $email }}" selected>{{ $email }}</option>
                            @endforeach
                        @endif
                    </select>
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
                    <input type="text" name="subject" id="subject"
                        value="{{ old('subject') }}"
                        class="form-control">
                </div>

                <!-- Body -->
                <div class="mb-3">
                    <label>Body</label>
                    <textarea name="body" id="editor" rows="8" class="form-control">
                        {{ old('body') }}
                    </textarea>
                </div>

                <div id="placeholders" class="mb-3"></div>

            </div>

            <div class="card-footer text-end">
                <button class="btn btn-success">
                    <i class="fas fa-paper-plane"></i> Send Email
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('css')
<link rel="stylesheet"  href="{{ asset('style/commonindex.css') }}">
<style> 
.card {
    border-radius: 12px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

</style>
@endpush

@push('js')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
// CKEditor
CKEDITOR.replace('editor',{height:300});

// Select2 init
$('.select2').select2({
    tags:true,
    tokenSeparators:[',',';'],
    width:'100%'
});

// 🔥 IMPORTANT: Prefill CKEditor after load
window.onload = function(){
    let oldData = document.getElementById('editor').value;
    if(oldData){
        CKEDITOR.instances.editor.setData(oldData);
    }
};

// Module change -> fetch recipients
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
                if(item.email){
                    rec.push({id:item.email,text:item.full_name+' <'+item.email+'>'});
                }
            }

            if(module=='customer'){
                if(item.contact_person_1_email){
                    rec.push({
                        id:item.contact_person_1_email,
                        text:item.company_name+' <'+item.contact_person_1_email+'>'
                    });
                }

                ['contact_person_2_email','contact_person_3_email','contact_person_4_email','contact_person_5_email','contact_person_6_email']
                .forEach(k=>{
                    if(item[k]){
                        cc.push({id:item[k],text:item[k]});
                    }
                });
            }
        });

        // Load Recipients
        let r = $('#recipients');
        r.empty();
        rec.forEach(o=>{
            let option = new Option(o.text,o.id,true,true);
            r.append(option);
        });
        r.trigger('change');

        // Load CC
        let c = $('#cc');
        c.empty();
        cc.forEach(o=>{
            let option = new Option(o.text,o.id,true,true);
            c.append(option);
        });
        c.trigger('change');

    });
});

// Template change
$('#templateSelect').on('change',function(){

    let id = $(this).val();
    if(!id) return;

    fetch('/emails/get-template/'+id)
    .then(res=>res.json())
    .then(data=>{
        $('#subject').val(data.subject);
        CKEDITOR.instances.editor.setData(data.body);
    });

});
</script>
@endpush