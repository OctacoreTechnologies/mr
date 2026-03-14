<!DOCTYPE html>
<html lang="en">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<head>
  <meta charset="UTF-8">
  <style>
    @page {
      margin:30px;
    }
 
    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        src: url('{{ public_path('fonts/Poppins-Regular.ttf') }}') format('truetype'); 
    }
    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 700;
        src: url('{{ public_path('fonts/Poppins-Bold.ttf') }}') format('truetype');
    }
    
    .bold-text {
        font-weight:700; /* or 700 */
    }
    body {
      margin-top: 0;
      padding: 20px;
      font-family:'Poppins',sans-serif ;
      border: 2px solid black;
      font-optical-sizing: auto;

    }

    header {
      position: fixed;
  
      right: 25px;

      height: 100px;
    
      z-index: 15;
  
    }

    .client-info {
      text-align: center;
      position: absolute;
      top: 40px;
    }

    .container {
      background: #fff;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
    }

    .page-break {
      page-break-before: always;
     
    }

    .pagenum:before {
      content: counter(page);
    }

    .content-wrapper {
     
      position: absolute;
      top:150px;
      left: 100px;
      height: auto;
      object-fit: contain;
    }

     

    .client-footer {
      position: relative;
      width: 142%;
      border-top: 2px dashed black;
    }

    .client-footer table {

      position: relative;
      top: 20px;
      font-size: 15px;
      border-collapse: separate;
      margin-top: 10px;
    }



    .dashed-border {
      position: relative;
    }


    .table-index {
      position: relative;
      bottom: -80px;
    }

    .techincal-data {
     position: relative;
      
    }


    .technical-data-sub-head h3 {
      padding: 6px 0px 6px 15px;
      color:black;
      font-size: small;
      text-decoration: underline;
    }
  
    .tech-content{
      padding-left: 5px;  
     
    }

    .offer {
      position: relative;
      top: 95px;
     
    }

   .lastpage{
    position: relative;
    top:120px;

   }

    .website {
      margin-top: 5px;
    }

    footer {
      width: 85%;
      font-size: 8px;
      color: #000;
      position: fixed;
      left: 0;
      background-color: #fff;
    }

    .footer-content {
      display: flex;
      justify-content: space-between;
      align-items: flex-start; 
      border-top: 2px solid #000;
  

    }

    .footer-content div {
      float: left;
      padding-left: 10px; 
    }

   

    .footer-content::after {
      content: "";
      display: block;
      clear: both;
    }

    .footer-content {
      position: fixed;
      bottom: 10px;
      /* Adjust if needed */
      left: 12px;
      width: 95%;
      font-size: 11px;

      /* line-height: normal; */
      color: #000;
      border-top: 1px solid #2daae3;
      padding:0 10px 0 0;
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid #2daae3;
 
  
    }

    .footer-content div {
      width: 34%;
      /* border-right: 2px solid black; */
      line-height: 1;
      height: 6%;
      margin-bottom:35px;
      
    }

    .footer-content p {
    
      word-wrap:break-word;
    }

    /* Decorative Image */
   
    .footer-page-number:after {
     content: "" counter(page);
     font-family: 'Poppins';
     font-weight:bolder;
     
    }
    .footer-page-number {
       font-size: 14px;

       font-weight: bolder;
       position: relative;
       top:32px;  
       left: 22px;
  }
  .techincal-specification{
    position: relative;
    top:93px;
    right:10px;
    margin-bottom: 30px;
  }
   .specification{
    position: relative;
    top:66px;
    right:20px;
  }
  .parameter-table {
     width: 90%;
     table-layout: fixed;
     page-break-inside: avoid; 
    
  }

.parameter-table td {
  padding: 8px;
  vertical-align: top;
  white-space: nowrap; 
  overflow: hidden;
  text-overflow: ellipsis;
}

.parameter-table td:nth-child(1) {
  width: 35%;
}

.parameter-table td:nth-child(2) {
  width: 65%;
  white-space: normal; 
}
.submitted{
   position: relative;
   top:270px;
   padding: 0;
   margin: 0;
   left: 23px;
 }
 .footer-col-border::after {
    content: "";
    position: absolute;
    top: 10px;
    right: 0;
    height: 100%; 
    border-right: 1px solid black;
  }
  .footer-col {
    width: 33%;
    position: relative;
    padding-right: 2px;
  }
  .footer-col p {
    margin: 0;
    
  }
  .img{
    position: relative;
    top: 200px;
    left: 0;
  }
  .table-index{
    padding: 0 10px 0 15px;
  }
  .offer-table{
    position:relative;
    top:120px;
    right: 28px;
    margin-bottom: 390px;
  }

.offer-table tr{
  page-break-inside: avoid;
}

.offer-table thead{
  display: table-header-group;
}

.offer-table tbody{
  page-break-inside:auto;
}.offer-table{

  page-break-inside:auto;
}
.offer-table tr{
  page-break-inside: avoid;
}

.offer-table thead{
  display: table-header-group;
}

.offer-table tbody{
  page-break-inside:auto;
}
.offer-heading{
  position: relative;
  right: 30px;
}
.term{
  position: relative;
  top:95px;
  right:10px;
}
.app-image{
  position: relative;
  right:20px;
}
.techincal-specification{
    position:relative;
    /* top:120px;
    right: 28px; */
    margin-bottom: 30px;
  }
</style>
</head>

<body>
  <!-- Header -->
  <header>
    <div style="text-align: right;">
        <img src="{{ asset('/image/mr_logo.png') }}" height="80px" >
    </div>
  </header>

  <div class="footer-content">
    <div class="footer-col footer-col-border" style="word-wrap: break-word;">
      <b>Register Office:</b>
      <p> Room No. 16, 2nd Floor BhagawanNivas</p>
      <p>Near Sub Register Office, Station Road</p>
      <p>Goregaon West, Mumbai – 400 062</p>
      <p>E-Mail: <span style="color: #2daae3;">info@mrengineers.co.in</span></p>
    </div>
    <div  class="footer-col footer-col-border" style="padding-left: 25px; width: 40%;">
      <b>Factory </b>
      <p>351 /A & 351 /B, PSL Compound, Near EPL</p>
      <p>Kachigam Char Rasta, Village Kachigam Nani</p>
      <p>Daman (UT), Daman –396210</p>
      <p>Website: <span style="color: #2daae3;">www.mrengineers.co.in</span></p>
    </div>
    <div class="footer-page-number" style="padding-left: 20px">
      <span style="color: rgba(0, 0, 0, 0.301)">Page |</span>
    </div>
  </div>
