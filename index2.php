<?php
require_once "./config/includes.php";
header("X-Robots-Tag: all");
if(isset($_POST["status"])) {

if($_POST["status"] == 'roll'){
		$dado = DadoDinamico(cleanstring($_POST["dado"], 50));
		$dano = intval(minmax($_POST["dano"], 0, 1));
		if (ClearRolar($dado)) {
			$data["success"] = true;
			$data = RolarMkII($dado, $dano);
		} else {
			$data = ClearRolar($dado, true);
		}
		$data["dado"] = $dado;
		echo json_encode($data);
		exit;
	}
}

?>
<!doctype html>
<html lang="br">
<head>
    <!-- Required meta tags -->
    <title>Fichas Ordem Paranormal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fichas Ordem Paranormal. Venha construir a sua missão com seus amigos. De forma prática, moderna e completa.">
    <meta name="keywords" content="RPG de mesa, rpg, ordem, ordem paranormal, paranormal, calamidade, desconjuração, os, espinhos,da , aurora, escarlate, missão, a, cellbit, fichasop, fichas op, fichas, op">
    <meta name="author" content="Lucas Pinheiro">
    <link id="favicon" href="/favicon.png" rel="icon"/>
    <style>
        /*! CSS Used from: https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css */
        :root{--bs-blue:#0d6efd;--bs-indigo:#6610f2;--bs-purple:#6f42c1;--bs-pink:#d63384;--bs-red:#dc3545;--bs-orange:#fd7e14;--bs-yellow:#ffc107;--bs-green:#198754;--bs-teal:#20c997;--bs-cyan:#0dcaf0;--bs-black:#000;--bs-white:#fff;--bs-gray:#6c757d;--bs-gray-dark:#343a40;--bs-gray-100:#f8f9fa;--bs-gray-200:#e9ecef;--bs-gray-300:#dee2e6;--bs-gray-400:#ced4da;--bs-gray-500:#adb5bd;--bs-gray-600:#6c757d;--bs-gray-700:#495057;--bs-gray-800:#343a40;--bs-gray-900:#212529;--bs-primary:#0d6efd;--bs-secondary:#6c757d;--bs-success:#198754;--bs-info:#0dcaf0;--bs-warning:#ffc107;--bs-danger:#dc3545;--bs-light:#f8f9fa;--bs-dark:#212529;--bs-primary-rgb:13,110,253;--bs-secondary-rgb:108,117,125;--bs-success-rgb:25,135,84;--bs-info-rgb:13,202,240;--bs-warning-rgb:255,193,7;--bs-danger-rgb:220,53,69;--bs-light-rgb:248,249,250;--bs-dark-rgb:33,37,41;--bs-white-rgb:255,255,255;--bs-black-rgb:0,0,0;--bs-body-color-rgb:33,37,41;--bs-body-bg-rgb:255,255,255;--bs-font-sans-serif:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans","Liberation Sans",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--bs-font-monospace:SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--bs-gradient:linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));--bs-body-font-family:var(--bs-font-sans-serif);--bs-body-font-size:1rem;--bs-body-font-weight:400;--bs-body-line-height:1.5;--bs-body-color:#212529;--bs-body-bg:#fff;--bs-border-width:1px;--bs-border-style:solid;--bs-border-color:#dee2e6;--bs-border-color-translucent:rgba(0, 0, 0, 0.175);--bs-border-radius:0.375rem;--bs-border-radius-sm:0.25rem;--bs-border-radius-lg:0.5rem;--bs-border-radius-xl:1rem;--bs-border-radius-2xl:2rem;--bs-border-radius-pill:50rem;--bs-link-color:#0d6efd;--bs-link-hover-color:#0a58ca;--bs-code-color:#d63384;--bs-highlight-bg:#fff3cd;}
        *,::after,::before{box-sizing:border-box;}
        @media (prefers-reduced-motion:no-preference){
            :root{scroll-behavior:smooth;}
        }
        body{margin:0;font-family:var(--bs-body-font-family);font-size:var(--bs-body-font-size);font-weight:var(--bs-body-font-weight);line-height:var(--bs-body-line-height);color:var(--bs-body-color);text-align:var(--bs-body-text-align);background-color:var(--bs-body-bg);-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent;}
        hr{margin:1rem 0;color:inherit;border:0;border-top:1px solid;opacity:.25;}
        h2,h3,h5{margin-top:0;margin-bottom:.5rem;font-weight:500;line-height:1.2;}
        h2{font-size:calc(1.325rem + .9vw);}
        @media (min-width:1200px){
            h2{font-size:2rem;}
        }
        h3{font-size:calc(1.3rem + .6vw);}
        @media (min-width:1200px){
            h3{font-size:1.75rem;}
        }
        h5{font-size:1.25rem;}
        p{margin-top:0;margin-bottom:1rem;}
        ol{padding-left:2rem;}
        ol{margin-top:0;margin-bottom:1rem;}
        strong{font-weight:bolder;}
        a{color:var(--bs-link-color);text-decoration:underline;}
        a:hover{color:var(--bs-link-hover-color);}
        code{font-family:var(--bs-font-monospace);font-size:1em;}
        code{font-size:.875em;color:var(--bs-code-color);word-wrap:break-word;}
        img{vertical-align:middle;}
        label{display:inline-block;}
        button{border-radius:0;}
        button:focus:not(:focus-visible){outline:0;}
        button,input,select{margin:0;font-family:inherit;font-size:inherit;line-height:inherit;}
        button,select{text-transform:none;}
        [role=button]{cursor:pointer;}
        select{word-wrap:normal;}
        select:disabled{opacity:1;}
        [type=button],[type=submit],button{-webkit-appearance:button;}
        ::-moz-focus-inner{padding:0;border-style:none;}
        .lead{font-size:1.25rem;font-weight:300;}
        .img-fluid{max-width:100%;height:auto;}
        .container,.container-fluid{--bs-gutter-x:1.5rem;--bs-gutter-y:0;width:100%;padding-right:calc(var(--bs-gutter-x) * .5);padding-left:calc(var(--bs-gutter-x) * .5);margin-right:auto;margin-left:auto;}
        @media (min-width:576px){
            .container{max-width:540px;}
        }
        @media (min-width:768px){
            .container{max-width:720px;}
        }
        @media (min-width:992px){
            .container{max-width:960px;}
        }
        @media (min-width:1200px){
            .container{max-width:1140px;}
        }
        @media (min-width:1400px){
            .container{max-width:1320px;}
        }
        .row{--bs-gutter-x:1.5rem;--bs-gutter-y:0;display:flex;flex-wrap:wrap;margin-top:calc(-1 * var(--bs-gutter-y));margin-right:calc(-.5 * var(--bs-gutter-x));margin-left:calc(-.5 * var(--bs-gutter-x));}
        .row>*{flex-shrink:0;width:100%;max-width:100%;padding-right:calc(var(--bs-gutter-x) * .5);padding-left:calc(var(--bs-gutter-x) * .5);margin-top:var(--bs-gutter-y);}
        .col{flex:1 0 0%;}
        .col-auto{flex:0 0 auto;width:auto;}
        .col-6{flex:0 0 auto;width:50%;}
        @media (min-width:768px){
            .col-md{flex:1 0 0%;}
            .col-md-5{flex:0 0 auto;width:41.66666667%;}
            .col-md-7{flex:0 0 auto;width:58.33333333%;}
        }
        @media (min-width:992px){
            .col-lg-4{flex:0 0 auto;width:33.33333333%;}
        }
        .form-control{display:block;width:100%;padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;-webkit-appearance:none;-moz-appearance:none;appearance:none;border-radius:.375rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .form-control{transition:none;}
        }
        .form-control:focus{color:#212529;background-color:#fff;border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
        .form-control::-moz-placeholder{color:#6c757d;opacity:1;}
        .form-control::placeholder{color:#6c757d;opacity:1;}
        .form-control:disabled{background-color:#e9ecef;opacity:1;}
        .form-select{display:block;width:100%;padding:.375rem 2.25rem .375rem .75rem;-moz-padding-start:calc(0.75rem - 3px);font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff;background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");background-repeat:no-repeat;background-position:right .75rem center;background-size:16px 12px;border:1px solid #ced4da;border-radius:.375rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;-webkit-appearance:none;-moz-appearance:none;appearance:none;}
        @media (prefers-reduced-motion:reduce){
            .form-select{transition:none;}
        }
        .form-select:focus{border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
        .form-select:disabled{background-color:#e9ecef;}
        .form-select:-moz-focusring{color:transparent;text-shadow:0 0 0 #212529;}
        .form-check{display:block;min-height:1.5rem;padding-left:1.5em;margin-bottom:.125rem;}
        .form-check .form-check-input{float:left;margin-left:-1.5em;}
        .form-check-input{width:1em;height:1em;margin-top:.25em;vertical-align:top;background-color:#fff;background-repeat:no-repeat;background-position:center;background-size:contain;border:1px solid rgba(0,0,0,.25);-webkit-appearance:none;-moz-appearance:none;appearance:none;-webkit-print-color-adjust:exact;color-adjust:exact;print-color-adjust:exact;}
        .form-check-input[type=checkbox]{border-radius:.25em;}
        .form-check-input:active{filter:brightness(90%);}
        .form-check-input:focus{border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
        .form-check-input:checked{background-color:#0d6efd;border-color:#0d6efd;}
        .form-check-input:checked[type=checkbox]{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");}
        .form-check-input:disabled{pointer-events:none;filter:none;opacity:.5;}
        .form-check-input:disabled~.form-check-label{cursor:default;opacity:.5;}
        .form-switch{padding-left:2.5em;}
        .form-switch .form-check-input{width:2em;margin-left:-2.5em;background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");background-position:left center;border-radius:2em;transition:background-position .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .form-switch .form-check-input{transition:none;}
        }
        .form-switch .form-check-input:focus{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%2386b7fe'/%3e%3c/svg%3e");}
        .form-switch .form-check-input:checked{background-position:right center;background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");}
        .input-group{position:relative;display:flex;flex-wrap:wrap;align-items:stretch;width:100%;}
        .input-group>.form-control{position:relative;flex:1 1 auto;width:1%;min-width:0;}
        .input-group>.form-control:focus{z-index:3;}
        .input-group-text{display:flex;align-items:center;padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:center;white-space:nowrap;background-color:#e9ecef;border:1px solid #ced4da;border-radius:.375rem;}
        .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating){border-top-right-radius:0;border-bottom-right-radius:0;}
        .input-group>:not(:first-child):not(.dropdown-menu):not(.form-floating):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback){margin-left:-1px;border-top-left-radius:0;border-bottom-left-radius:0;}
        .btn{--bs-btn-padding-x:0.75rem;--bs-btn-padding-y:0.375rem;--bs-btn-font-size:1rem;--bs-btn-font-weight:400;--bs-btn-line-height:1.5;--bs-btn-color:#212529;--bs-btn-bg:transparent;--bs-btn-border-width:1px;--bs-btn-border-color:transparent;--bs-btn-border-radius:0.375rem;--bs-btn-box-shadow:inset 0 1px 0 rgba(255, 255, 255, 0.15),0 1px 1px rgba(0, 0, 0, 0.075);--bs-btn-disabled-opacity:0.65;--bs-btn-focus-box-shadow:0 0 0 0.25rem rgba(var(--bs-btn-focus-shadow-rgb), .5);display:inline-block;padding:var(--bs-btn-padding-y) var(--bs-btn-padding-x);font-family:var(--bs-btn-font-family);font-size:var(--bs-btn-font-size);font-weight:var(--bs-btn-font-weight);line-height:var(--bs-btn-line-height);color:var(--bs-btn-color);text-align:center;text-decoration:none;vertical-align:middle;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;user-select:none;border:var(--bs-btn-border-width) solid var(--bs-btn-border-color);border-radius:var(--bs-btn-border-radius);background-color:var(--bs-btn-bg);transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .btn{transition:none;}
        }
        .btn:hover{color:var(--bs-btn-hover-color);background-color:var(--bs-btn-hover-bg);border-color:var(--bs-btn-hover-border-color);}
        .btn:focus{color:var(--bs-btn-hover-color);background-color:var(--bs-btn-hover-bg);border-color:var(--bs-btn-hover-border-color);outline:0;box-shadow:var(--bs-btn-focus-box-shadow);}
        .btn:active{color:var(--bs-btn-active-color);background-color:var(--bs-btn-active-bg);border-color:var(--bs-btn-active-border-color);}
        .btn:active:focus{box-shadow:var(--bs-btn-focus-box-shadow);}
        .btn:disabled{color:var(--bs-btn-disabled-color);pointer-events:none;background-color:var(--bs-btn-disabled-bg);border-color:var(--bs-btn-disabled-border-color);opacity:var(--bs-btn-disabled-opacity);}
        .btn-success{--bs-btn-color:#fff;--bs-btn-bg:#198754;--bs-btn-border-color:#198754;--bs-btn-hover-color:#fff;--bs-btn-hover-bg:#157347;--bs-btn-hover-border-color:#146c43;--bs-btn-focus-shadow-rgb:60,153,110;--bs-btn-active-color:#fff;--bs-btn-active-bg:#146c43;--bs-btn-active-border-color:#13653f;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#fff;--bs-btn-disabled-bg:#198754;--bs-btn-disabled-border-color:#198754;}
        .btn-outline-primary{--bs-btn-color:#0d6efd;--bs-btn-border-color:#0d6efd;--bs-btn-hover-color:#fff;--bs-btn-hover-bg:#0d6efd;--bs-btn-hover-border-color:#0d6efd;--bs-btn-focus-shadow-rgb:13,110,253;--bs-btn-active-color:#fff;--bs-btn-active-bg:#0d6efd;--bs-btn-active-border-color:#0d6efd;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#0d6efd;--bs-btn-disabled-bg:transparent;--bs-btn-disabled-border-color:#0d6efd;--bs-gradient:none;}
        .btn-outline-success{--bs-btn-color:#198754;--bs-btn-border-color:#198754;--bs-btn-hover-color:#fff;--bs-btn-hover-bg:#198754;--bs-btn-hover-border-color:#198754;--bs-btn-focus-shadow-rgb:25,135,84;--bs-btn-active-color:#fff;--bs-btn-active-bg:#198754;--bs-btn-active-border-color:#198754;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#198754;--bs-btn-disabled-bg:transparent;--bs-btn-disabled-border-color:#198754;--bs-gradient:none;}
        .btn-outline-info{--bs-btn-color:#0dcaf0;--bs-btn-border-color:#0dcaf0;--bs-btn-hover-color:#000;--bs-btn-hover-bg:#0dcaf0;--bs-btn-hover-border-color:#0dcaf0;--bs-btn-focus-shadow-rgb:13,202,240;--bs-btn-active-color:#000;--bs-btn-active-bg:#0dcaf0;--bs-btn-active-border-color:#0dcaf0;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#0dcaf0;--bs-btn-disabled-bg:transparent;--bs-btn-disabled-border-color:#0dcaf0;--bs-gradient:none;}
        .btn-outline-danger{--bs-btn-color:#dc3545;--bs-btn-border-color:#dc3545;--bs-btn-hover-color:#fff;--bs-btn-hover-bg:#dc3545;--bs-btn-hover-border-color:#dc3545;--bs-btn-focus-shadow-rgb:220,53,69;--bs-btn-active-color:#fff;--bs-btn-active-bg:#dc3545;--bs-btn-active-border-color:#dc3545;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#dc3545;--bs-btn-disabled-bg:transparent;--bs-btn-disabled-border-color:#dc3545;--bs-gradient:none;}
        .btn-sm{--bs-btn-padding-y:0.25rem;--bs-btn-padding-x:0.5rem;--bs-btn-font-size:0.875rem;--bs-btn-border-radius:0.25rem;}
        .fade{transition:opacity .15s linear;}
        @media (prefers-reduced-motion:reduce){
            .fade{transition:none;}
        }
        .fade:not(.show){opacity:0;}
        .dropdown{position:relative;}
        .dropdown-menu{--bs-dropdown-min-width:10rem;--bs-dropdown-padding-x:0;--bs-dropdown-padding-y:0.5rem;--bs-dropdown-spacer:0.125rem;--bs-dropdown-font-size:1rem;--bs-dropdown-color:#212529;--bs-dropdown-bg:#fff;--bs-dropdown-border-color:var(--bs-border-color-translucent);--bs-dropdown-border-radius:0.375rem;--bs-dropdown-border-width:1px;--bs-dropdown-inner-border-radius:calc(0.375rem - 1px);--bs-dropdown-divider-bg:var(--bs-border-color-translucent);--bs-dropdown-divider-margin-y:0.5rem;--bs-dropdown-box-shadow:0 0.5rem 1rem rgba(0, 0, 0, 0.15);--bs-dropdown-link-color:#212529;--bs-dropdown-link-hover-color:#1e2125;--bs-dropdown-link-hover-bg:#e9ecef;--bs-dropdown-link-active-color:#fff;--bs-dropdown-link-active-bg:#0d6efd;--bs-dropdown-link-disabled-color:#adb5bd;--bs-dropdown-item-padding-x:1rem;--bs-dropdown-item-padding-y:0.25rem;--bs-dropdown-header-color:#6c757d;--bs-dropdown-header-padding-x:1rem;--bs-dropdown-header-padding-y:0.5rem;position:absolute;z-index:1000;display:none;min-width:var(--bs-dropdown-min-width);padding:var(--bs-dropdown-padding-y) var(--bs-dropdown-padding-x);margin:0;font-size:var(--bs-dropdown-font-size);color:var(--bs-dropdown-color);text-align:left;list-style:none;background-color:var(--bs-dropdown-bg);background-clip:padding-box;border:var(--bs-dropdown-border-width) solid var(--bs-dropdown-border-color);border-radius:var(--bs-dropdown-border-radius);}
        .dropdown-item{display:block;width:100%;padding:var(--bs-dropdown-item-padding-y) var(--bs-dropdown-item-padding-x);clear:both;font-weight:400;color:var(--bs-dropdown-link-color);text-align:inherit;text-decoration:none;white-space:nowrap;background-color:transparent;border:0;}
        .dropdown-item:focus,.dropdown-item:hover{color:var(--bs-dropdown-link-hover-color);background-color:var(--bs-dropdown-link-hover-bg);}
        .dropdown-item:active{color:var(--bs-dropdown-link-active-color);text-decoration:none;background-color:var(--bs-dropdown-link-active-bg);}
        .dropdown-item:disabled{color:var(--bs-dropdown-link-disabled-color);pointer-events:none;background-color:transparent;}
        .dropdown-menu-dark{--bs-dropdown-color:#dee2e6;--bs-dropdown-bg:#343a40;--bs-dropdown-border-color:var(--bs-border-color-translucent);--bs-dropdown-link-color:#dee2e6;--bs-dropdown-link-hover-color:#fff;--bs-dropdown-divider-bg:var(--bs-border-color-translucent);--bs-dropdown-link-hover-bg:rgba(255, 255, 255, 0.15);--bs-dropdown-link-active-color:#fff;--bs-dropdown-link-active-bg:#0d6efd;--bs-dropdown-link-disabled-color:#adb5bd;--bs-dropdown-header-color:#adb5bd;}
        .btn-close{box-sizing:content-box;width:1em;height:1em;padding:.25em .25em;color:#000;background:transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;border:0;border-radius:.375rem;opacity:.5;}
        .btn-close:hover{color:#000;text-decoration:none;opacity:.75;}
        .btn-close:focus{outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);opacity:1;}
        .btn-close:disabled{pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none;opacity:.25;}
        .btn-close-white{filter:invert(1) grayscale(100%) brightness(200%);}
        .toast{--bs-toast-padding-x:0.75rem;--bs-toast-padding-y:0.5rem;--bs-toast-spacing:1.5rem;--bs-toast-max-width:350px;--bs-toast-font-size:0.875rem;--bs-toast-bg:rgba(255, 255, 255, 0.85);--bs-toast-border-width:1px;--bs-toast-border-color:var(--bs-border-color-translucent);--bs-toast-border-radius:0.375rem;--bs-toast-box-shadow:0 0.5rem 1rem rgba(0, 0, 0, 0.15);--bs-toast-header-color:#6c757d;--bs-toast-header-bg:rgba(255, 255, 255, 0.85);--bs-toast-header-border-color:rgba(0, 0, 0, 0.05);width:var(--bs-toast-max-width);max-width:100%;font-size:var(--bs-toast-font-size);color:var(--bs-toast-color);pointer-events:auto;background-color:var(--bs-toast-bg);background-clip:padding-box;border:var(--bs-toast-border-width) solid var(--bs-toast-border-color);box-shadow:var(--bs-toast-box-shadow);border-radius:var(--bs-toast-border-radius);}
        .toast:not(.show){display:none;}
        .toast-header{display:flex;align-items:center;padding:var(--bs-toast-padding-y) var(--bs-toast-padding-x);color:var(--bs-toast-header-color);background-color:var(--bs-toast-header-bg);background-clip:padding-box;border-bottom:var(--bs-toast-border-width) solid var(--bs-toast-header-border-color);border-top-left-radius:calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));border-top-right-radius:calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));}
        .toast-header .btn-close{margin-right:calc(var(--bs-toast-padding-x) * -.5);margin-left:var(--bs-toast-padding-x);}
        .toast-body{padding:var(--bs-toast-padding-x);word-wrap:break-word;}
        .modal{--bs-modal-zindex:1055;--bs-modal-width:500px;--bs-modal-padding:1rem;--bs-modal-margin:0.5rem;--bs-modal-bg:#fff;--bs-modal-border-color:var(--bs-border-color-translucent);--bs-modal-border-width:1px;--bs-modal-border-radius:0.5rem;--bs-modal-box-shadow:0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);--bs-modal-inner-border-radius:calc(0.5rem - 1px);--bs-modal-header-padding-x:1rem;--bs-modal-header-padding-y:1rem;--bs-modal-header-padding:1rem 1rem;--bs-modal-header-border-color:var(--bs-border-color);--bs-modal-header-border-width:1px;--bs-modal-title-line-height:1.5;--bs-modal-footer-gap:0.5rem;--bs-modal-footer-border-color:var(--bs-border-color);--bs-modal-footer-border-width:1px;position:fixed;top:0;left:0;z-index:var(--bs-modal-zindex);display:none;width:100%;height:100%;overflow-x:hidden;overflow-y:auto;outline:0;}
        .modal-dialog{position:relative;width:auto;margin:var(--bs-modal-margin);pointer-events:none;}
        .modal.fade .modal-dialog{transition:transform .3s ease-out;transform:translate(0,-50px);}
        @media (prefers-reduced-motion:reduce){
            .modal.fade .modal-dialog{transition:none;}
        }
        .modal-content{position:relative;display:flex;flex-direction:column;width:100%;color:var(--bs-modal-color);pointer-events:auto;background-color:var(--bs-modal-bg);background-clip:padding-box;border:var(--bs-modal-border-width) solid var(--bs-modal-border-color);border-radius:var(--bs-modal-border-radius);outline:0;}
        .modal-header{display:flex;flex-shrink:0;align-items:center;justify-content:space-between;padding:var(--bs-modal-header-padding);border-bottom:var(--bs-modal-header-border-width) solid var(--bs-modal-header-border-color);border-top-left-radius:var(--bs-modal-inner-border-radius);border-top-right-radius:var(--bs-modal-inner-border-radius);}
        .modal-header .btn-close{padding:calc(var(--bs-modal-header-padding-y) * .5) calc(var(--bs-modal-header-padding-x) * .5);margin:calc(var(--bs-modal-header-padding-y) * -.5) calc(var(--bs-modal-header-padding-x) * -.5) calc(var(--bs-modal-header-padding-y) * -.5) auto;}
        .modal-title{margin-bottom:0;line-height:var(--bs-modal-title-line-height);}
        .modal-body{position:relative;flex:1 1 auto;padding:var(--bs-modal-padding);}
        .modal-footer{display:flex;flex-shrink:0;flex-wrap:wrap;align-items:center;justify-content:flex-end;padding:calc(var(--bs-modal-padding) - var(--bs-modal-footer-gap) * .5);background-color:var(--bs-modal-footer-bg);border-top:var(--bs-modal-footer-border-width) solid var(--bs-modal-footer-border-color);border-bottom-right-radius:var(--bs-modal-inner-border-radius);border-bottom-left-radius:var(--bs-modal-inner-border-radius);}
        .modal-footer>*{margin:calc(var(--bs-modal-footer-gap) * .5);}
        @media (min-width:576px){
            .modal{--bs-modal-margin:1.75rem;--bs-modal-box-shadow:0 0.5rem 1rem rgba(0, 0, 0, 0.15);}
            .modal-dialog{max-width:var(--bs-modal-width);margin-right:auto;margin-left:auto;}
        }
        @media (min-width:992px){
            .modal-lg{--bs-modal-width:800px;}
        }
        .modal-fullscreen{width:100vw;max-width:none;height:100%;margin:0;}
        .modal-fullscreen .modal-content{height:100%;border:0;border-radius:0;}
        .modal-fullscreen .modal-body{overflow-y:auto;}
        .clearfix::after{display:block;clear:both;content:"";}
        .fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030;}
        .fixed-bottom{position:fixed;right:0;bottom:0;left:0;z-index:1030;}
        .float-start{float:left!important;}
        .float-end{float:right!important;}
        .d-flex{display:flex!important;}
        .d-none{display:none!important;}
        .position-fixed{position:fixed!important;}
        .top-50{top:50%!important;}
        .start-50{left:50%!important;}
        .translate-middle{transform:translate(-50%,-50%)!important;}
        .border{border:var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;}
        .border-0{border:0!important;}
        .border-top{border-top:var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;}
        .border-top-0{border-top:0!important;}
        .border-end-0{border-right:0!important;}
        .border-bottom{border-bottom:var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;}
        .border-bottom-0{border-bottom:0!important;}
        .border-start-0{border-left:0!important;}
        .border-success{--bs-border-opacity:1;border-color:rgba(var(--bs-success-rgb),var(--bs-border-opacity))!important;}
        .border-light{--bs-border-opacity:1;border-color:rgba(var(--bs-light-rgb),var(--bs-border-opacity))!important;}
        .border-dark{--bs-border-opacity:1;border-color:rgba(var(--bs-dark-rgb),var(--bs-border-opacity))!important;}
        .border-white{--bs-border-opacity:1;border-color:rgba(var(--bs-white-rgb),var(--bs-border-opacity))!important;}
        .border-1{--bs-border-width:1px;}
        .flex-wrap{flex-wrap:wrap!important;}
        .justify-content-between{justify-content:space-between!important;}
        .m-1{margin:.25rem!important;}
        .m-2{margin:.5rem!important;}
        .m-3{margin:1rem!important;}
        .mx-2{margin-right:.5rem!important;margin-left:.5rem!important;}
        .mx-3{margin-right:1rem!important;margin-left:1rem!important;}
        .mx-auto{margin-right:auto!important;margin-left:auto!important;}
        .my-1{margin-top:.25rem!important;margin-bottom:.25rem!important;}
        .my-5{margin-top:3rem!important;margin-bottom:3rem!important;}
        .me-auto{margin-right:auto!important;}
        .mb-2{margin-bottom:.5rem!important;}
        .p-0{padding:0!important;}
        .fs-1{font-size:calc(1.375rem + 1.5vw)!important;}
        .fs-4{font-size:calc(1.275rem + .3vw)!important;}
        .fw-bolder{font-weight:bolder!important;}
        .text-start{text-align:left!important;}
        .text-center{text-align:center!important;}
        .text-decoration-none{text-decoration:none!important;}
        .text-decoration-underline{text-decoration:underline!important;}
        .text-success{--bs-text-opacity:1;color:rgba(var(--bs-success-rgb),var(--bs-text-opacity))!important;}
        .text-info{--bs-text-opacity:1;color:rgba(var(--bs-info-rgb),var(--bs-text-opacity))!important;}
        .text-danger{--bs-text-opacity:1;color:rgba(var(--bs-danger-rgb),var(--bs-text-opacity))!important;}
        .text-light{--bs-text-opacity:1;color:rgba(var(--bs-light-rgb),var(--bs-text-opacity))!important;}
        .text-white{--bs-text-opacity:1;color:rgba(var(--bs-white-rgb),var(--bs-text-opacity))!important;}
        .bg-dark{--bs-bg-opacity:1;background-color:rgba(var(--bs-dark-rgb),var(--bs-bg-opacity))!important;}
        .bg-black{--bs-bg-opacity:1;background-color:rgba(var(--bs-black-rgb),var(--bs-bg-opacity))!important;}
        .rounded-circle{border-radius:50%!important;}
        @media (min-width:768px){
            .d-md-block{display:block!important;}
            .d-md-none{display:none!important;}
            .order-md-1{order:1!important;}
            .order-md-2{order:2!important;}
        }
        @media (min-width:1200px){
            .fs-1{font-size:2.5rem!important;}
            .fs-4{font-size:1.5rem!important;}
        }
        /*! CSS Used from: Embedded */
        *::-webkit-scrollbar{width:5px;}
        *::-webkit-scrollbar-track{background:#000000;}
        *::-webkit-scrollbar-thumb{background-color:#ffffff;border-radius:3px;border:0 none #000000;}
        .font1{font-family:'Concert One', cursive;}
        .font5{font-family:'Permanent Marker', cursive;}
        .font6{font-family:'Special Elite', cursive;}
        .containera{position:relative;margin-left:auto;margin-right:auto;text-align:center;width:300px;height:auto;color:white;}
        :root{--bs-black-rgb:25,25,25;}
        /*! CSS Used from: Embedded */
        *,::after,::before{box-sizing:border-box;}
        body{margin:0;font-family:var(--bs-body-font-family);font-size:var(--bs-body-font-size);font-weight:var(--bs-body-font-weight);line-height:var(--bs-body-line-height);color:var(--bs-body-color);text-align:var(--bs-body-text-align);background-color:var(--bs-body-bg);-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent;}
        hr{margin:1rem 0;color:inherit;border:0;border-top:1px solid;opacity:.25;}
        h2,h3,h5{margin-top:0;margin-bottom:.5rem;font-weight:500;line-height:1.2;}
        h2{font-size:calc(1.325rem + .9vw);}
        @media (min-width:1200px){
            h2{font-size:2rem;}
        }
        h3{font-size:calc(1.3rem + .6vw);}
        @media (min-width:1200px){
            h3{font-size:1.75rem;}
        }
        h5{font-size:1.25rem;}
        p{margin-top:0;margin-bottom:1rem;}
        ol{padding-left:2rem;}
        ol{margin-top:0;margin-bottom:1rem;}
        strong{font-weight:bolder;}
        a{color:var(--bs-link-color);text-decoration:underline;}
        a:hover{color:var(--bs-link-hover-color);}
        code{font-family:var(--bs-font-monospace);font-size:1em;}
        code{font-size:.875em;color:var(--bs-code-color);word-wrap:break-word;}
        img{vertical-align:middle;}
        label{display:inline-block;}
        button{border-radius:0;}
        button:focus:not(:focus-visible){outline:0;}
        button,input,select{margin:0;font-family:inherit;font-size:inherit;line-height:inherit;}
        button,select{text-transform:none;}
        [role=button]{cursor:pointer;}
        select{word-wrap:normal;}
        select:disabled{opacity:1;}
        [type=button],[type=submit],button{-webkit-appearance:button;}
        ::-moz-focus-inner{padding:0;border-style:none;}
        .lead{font-size:1.25rem;font-weight:300;}
        .img-fluid{max-width:100%;height:auto;}
        .container,.container-fluid{--bs-gutter-x:1.5rem;--bs-gutter-y:0;width:100%;padding-right:calc(var(--bs-gutter-x) * .5);padding-left:calc(var(--bs-gutter-x) * .5);margin-right:auto;margin-left:auto;}
        @media (min-width:576px){
            .container{max-width:540px;}
        }
        @media (min-width:768px){
            .container{max-width:720px;}
        }
        @media (min-width:992px){
            .container{max-width:960px;}
        }
        @media (min-width:1200px){
            .container{max-width:1140px;}
        }
        @media (min-width:1400px){
            .container{max-width:1320px;}
        }
        .row{--bs-gutter-x:1.5rem;--bs-gutter-y:0;display:flex;flex-wrap:wrap;margin-top:calc(-1 * var(--bs-gutter-y));margin-right:calc(-.5 * var(--bs-gutter-x));margin-left:calc(-.5 * var(--bs-gutter-x));}
        .row>*{flex-shrink:0;width:100%;max-width:100%;padding-right:calc(var(--bs-gutter-x) * .5);padding-left:calc(var(--bs-gutter-x) * .5);margin-top:var(--bs-gutter-y);}
        .col{flex:1 0 0%;}
        .col-auto{flex:0 0 auto;width:auto;}
        .col-6{flex:0 0 auto;width:50%;}
        @media (min-width:768px){
            .col-md{flex:1 0 0%;}
            .col-md-5{flex:0 0 auto;width:41.66666667%;}
            .col-md-7{flex:0 0 auto;width:58.33333333%;}
        }
        @media (min-width:992px){
            .col-lg-4{flex:0 0 auto;width:33.33333333%;}
        }
        .form-control{display:block;width:100%;padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff;background-clip:padding-box;border:1px solid #ced4da;-webkit-appearance:none;-moz-appearance:none;appearance:none;border-radius:.375rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .form-control{transition:none;}
        }
        .form-control:focus{color:#212529;background-color:#fff;border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
        .form-control::-moz-placeholder{color:#6c757d;opacity:1;}
        .form-control::placeholder{color:#6c757d;opacity:1;}
        .form-control:disabled{background-color:#e9ecef;opacity:1;}
        .form-select{display:block;width:100%;padding:.375rem 2.25rem .375rem .75rem;-moz-padding-start:calc(0.75rem - 3px);font-size:1rem;font-weight:400;line-height:1.5;color:#212529;background-color:#fff;background-image:url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);background-repeat:no-repeat;background-position:right .75rem center;background-size:16px 12px;border:1px solid #ced4da;border-radius:.375rem;transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out;-webkit-appearance:none;-moz-appearance:none;appearance:none;}
        @media (prefers-reduced-motion:reduce){
            .form-select{transition:none;}
        }
        .form-select:focus{border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
        .form-select:disabled{background-color:#e9ecef;}
        .form-select:-moz-focusring{color:transparent;text-shadow:0 0 0 #212529;}
        .form-check{display:block;min-height:1.5rem;padding-left:1.5em;margin-bottom:.125rem;}
        .form-check .form-check-input{float:left;margin-left:-1.5em;}
        .form-check-input{width:1em;height:1em;margin-top:.25em;vertical-align:top;background-color:#fff;background-repeat:no-repeat;background-position:center;background-size:contain;border:1px solid rgba(0,0,0,.25);-webkit-appearance:none;-moz-appearance:none;appearance:none;-webkit-print-color-adjust:exact;color-adjust:exact;print-color-adjust:exact;}
        .form-check-input[type=checkbox]{border-radius:.25em;}
        .form-check-input:active{filter:brightness(90%);}
        .form-check-input:focus{border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
        .form-check-input:checked{background-color:#0d6efd;border-color:#0d6efd;}
        .form-check-input:checked[type=checkbox]{background-image:url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e);}
        .form-check-input:disabled{pointer-events:none;filter:none;opacity:.5;}
        .form-check-input:disabled~.form-check-label{cursor:default;opacity:.5;}
        .form-switch{padding-left:2.5em;}
        .form-switch .form-check-input{width:2em;margin-left:-2.5em;background-image:url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e);background-position:left center;border-radius:2em;transition:background-position .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .form-switch .form-check-input{transition:none;}
        }
        .form-switch .form-check-input:focus{background-image:url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%2386b7fe'/%3e%3c/svg%3e);}
        .form-switch .form-check-input:checked{background-position:right center;background-image:url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e);}
        .input-group{position:relative;display:flex;flex-wrap:wrap;align-items:stretch;width:100%;}
        .input-group>.form-control{position:relative;flex:1 1 auto;width:1%;min-width:0;}
        .input-group>.form-control:focus{z-index:3;}
        .input-group-text{display:flex;align-items:center;padding:.375rem .75rem;font-size:1rem;font-weight:400;line-height:1.5;color:#212529;text-align:center;white-space:nowrap;background-color:#e9ecef;border:1px solid #ced4da;border-radius:.375rem;}
        .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating){border-top-right-radius:0;border-bottom-right-radius:0;}
        .input-group>:not(:first-child):not(.dropdown-menu):not(.form-floating):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback){margin-left:-1px;border-top-left-radius:0;border-bottom-left-radius:0;}
        .btn{--bs-btn-padding-x:0.75rem;--bs-btn-padding-y:0.375rem;--bs-btn-font-size:1rem;--bs-btn-font-weight:400;--bs-btn-line-height:1.5;--bs-btn-color:#212529;--bs-btn-bg:transparent;--bs-btn-border-width:1px;--bs-btn-border-color:transparent;--bs-btn-border-radius:0.375rem;--bs-btn-box-shadow:inset 0 1px 0 rgba(255, 255, 255, 0.15),0 1px 1px rgba(0, 0, 0, 0.075);--bs-btn-disabled-opacity:0.65;--bs-btn-focus-box-shadow:0 0 0 0.25rem rgba(var(--bs-btn-focus-shadow-rgb), .5);display:inline-block;padding:var(--bs-btn-padding-y) var(--bs-btn-padding-x);font-family:var(--bs-btn-font-family);font-size:var(--bs-btn-font-size);font-weight:var(--bs-btn-font-weight);line-height:var(--bs-btn-line-height);color:var(--bs-btn-color);text-align:center;text-decoration:none;vertical-align:middle;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;user-select:none;border:var(--bs-btn-border-width) solid var(--bs-btn-border-color);border-radius:var(--bs-btn-border-radius);background-color:var(--bs-btn-bg);transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
        @media (prefers-reduced-motion:reduce){
            .btn{transition:none;}
        }
        .btn:hover{color:var(--bs-btn-hover-color);background-color:var(--bs-btn-hover-bg);border-color:var(--bs-btn-hover-border-color);}
        .btn:focus{color:var(--bs-btn-hover-color);background-color:var(--bs-btn-hover-bg);border-color:var(--bs-btn-hover-border-color);outline:0;box-shadow:var(--bs-btn-focus-box-shadow);}
        .btn:active{color:var(--bs-btn-active-color);background-color:var(--bs-btn-active-bg);border-color:var(--bs-btn-active-border-color);}
        .btn:active:focus{box-shadow:var(--bs-btn-focus-box-shadow);}
        .btn:disabled{color:var(--bs-btn-disabled-color);pointer-events:none;background-color:var(--bs-btn-disabled-bg);border-color:var(--bs-btn-disabled-border-color);opacity:var(--bs-btn-disabled-opacity);}
        .btn-success{--bs-btn-color:#fff;--bs-btn-bg:#198754;--bs-btn-border-color:#198754;--bs-btn-hover-color:#fff;--bs-btn-hover-bg:#157347;--bs-btn-hover-border-color:#146c43;--bs-btn-focus-shadow-rgb:60,153,110;--bs-btn-active-color:#fff;--bs-btn-active-bg:#146c43;--bs-btn-active-border-color:#13653f;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#fff;--bs-btn-disabled-bg:#198754;--bs-btn-disabled-border-color:#198754;}
        .btn-outline-primary{--bs-btn-color:#0d6efd;--bs-btn-border-color:#0d6efd;--bs-btn-hover-color:#fff;--bs-btn-hover-bg:#0d6efd;--bs-btn-hover-border-color:#0d6efd;--bs-btn-focus-shadow-rgb:13,110,253;--bs-btn-active-color:#fff;--bs-btn-active-bg:#0d6efd;--bs-btn-active-border-color:#0d6efd;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#0d6efd;--bs-btn-disabled-bg:transparent;--bs-btn-disabled-border-color:#0d6efd;--bs-gradient:none;}
        .btn-outline-success{--bs-btn-color:#198754;--bs-btn-border-color:#198754;--bs-btn-hover-color:#fff;--bs-btn-hover-bg:#198754;--bs-btn-hover-border-color:#198754;--bs-btn-focus-shadow-rgb:25,135,84;--bs-btn-active-color:#fff;--bs-btn-active-bg:#198754;--bs-btn-active-border-color:#198754;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#198754;--bs-btn-disabled-bg:transparent;--bs-btn-disabled-border-color:#198754;--bs-gradient:none;}
        .btn-outline-info{--bs-btn-color:#0dcaf0;--bs-btn-border-color:#0dcaf0;--bs-btn-hover-color:#000;--bs-btn-hover-bg:#0dcaf0;--bs-btn-hover-border-color:#0dcaf0;--bs-btn-focus-shadow-rgb:13,202,240;--bs-btn-active-color:#000;--bs-btn-active-bg:#0dcaf0;--bs-btn-active-border-color:#0dcaf0;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#0dcaf0;--bs-btn-disabled-bg:transparent;--bs-btn-disabled-border-color:#0dcaf0;--bs-gradient:none;}
        .btn-outline-danger{--bs-btn-color:#dc3545;--bs-btn-border-color:#dc3545;--bs-btn-hover-color:#fff;--bs-btn-hover-bg:#dc3545;--bs-btn-hover-border-color:#dc3545;--bs-btn-focus-shadow-rgb:220,53,69;--bs-btn-active-color:#fff;--bs-btn-active-bg:#dc3545;--bs-btn-active-border-color:#dc3545;--bs-btn-active-shadow:inset 0 3px 5px rgba(0, 0, 0, 0.125);--bs-btn-disabled-color:#dc3545;--bs-btn-disabled-bg:transparent;--bs-btn-disabled-border-color:#dc3545;--bs-gradient:none;}
        .btn-sm{--bs-btn-padding-y:0.25rem;--bs-btn-padding-x:0.5rem;--bs-btn-font-size:0.875rem;--bs-btn-border-radius:0.25rem;}
        .fade{transition:opacity .15s linear;}
        @media (prefers-reduced-motion:reduce){
            .fade{transition:none;}
        }
        .fade:not(.show){opacity:0;}
        .dropdown{position:relative;}
        .dropdown-menu{--bs-dropdown-min-width:10rem;--bs-dropdown-padding-x:0;--bs-dropdown-padding-y:0.5rem;--bs-dropdown-spacer:0.125rem;--bs-dropdown-font-size:1rem;--bs-dropdown-color:#212529;--bs-dropdown-bg:#fff;--bs-dropdown-border-color:var(--bs-border-color-translucent);--bs-dropdown-border-radius:0.375rem;--bs-dropdown-border-width:1px;--bs-dropdown-inner-border-radius:calc(0.375rem - 1px);--bs-dropdown-divider-bg:var(--bs-border-color-translucent);--bs-dropdown-divider-margin-y:0.5rem;--bs-dropdown-box-shadow:0 0.5rem 1rem rgba(0, 0, 0, 0.15);--bs-dropdown-link-color:#212529;--bs-dropdown-link-hover-color:#1e2125;--bs-dropdown-link-hover-bg:#e9ecef;--bs-dropdown-link-active-color:#fff;--bs-dropdown-link-active-bg:#0d6efd;--bs-dropdown-link-disabled-color:#adb5bd;--bs-dropdown-item-padding-x:1rem;--bs-dropdown-item-padding-y:0.25rem;--bs-dropdown-header-color:#6c757d;--bs-dropdown-header-padding-x:1rem;--bs-dropdown-header-padding-y:0.5rem;position:absolute;z-index:1000;display:none;min-width:var(--bs-dropdown-min-width);padding:var(--bs-dropdown-padding-y) var(--bs-dropdown-padding-x);margin:0;font-size:var(--bs-dropdown-font-size);color:var(--bs-dropdown-color);text-align:left;list-style:none;background-color:var(--bs-dropdown-bg);background-clip:padding-box;border:var(--bs-dropdown-border-width) solid var(--bs-dropdown-border-color);border-radius:var(--bs-dropdown-border-radius);}
        .dropdown-item{display:block;width:100%;padding:var(--bs-dropdown-item-padding-y) var(--bs-dropdown-item-padding-x);clear:both;font-weight:400;color:var(--bs-dropdown-link-color);text-align:inherit;text-decoration:none;white-space:nowrap;background-color:transparent;border:0;}
        .dropdown-item:focus,.dropdown-item:hover{color:var(--bs-dropdown-link-hover-color);background-color:var(--bs-dropdown-link-hover-bg);}
        .dropdown-item:active{color:var(--bs-dropdown-link-active-color);text-decoration:none;background-color:var(--bs-dropdown-link-active-bg);}
        .dropdown-item:disabled{color:var(--bs-dropdown-link-disabled-color);pointer-events:none;background-color:transparent;}
        .dropdown-menu-dark{--bs-dropdown-color:#dee2e6;--bs-dropdown-bg:#343a40;--bs-dropdown-border-color:var(--bs-border-color-translucent);--bs-dropdown-link-color:#dee2e6;--bs-dropdown-link-hover-color:#fff;--bs-dropdown-divider-bg:var(--bs-border-color-translucent);--bs-dropdown-link-hover-bg:rgba(255, 255, 255, 0.15);--bs-dropdown-link-active-color:#fff;--bs-dropdown-link-active-bg:#0d6efd;--bs-dropdown-link-disabled-color:#adb5bd;--bs-dropdown-header-color:#adb5bd;}
        .btn-close{box-sizing:content-box;width:1em;height:1em;padding:.25em .25em;color:#000;background:transparent url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 0 1 1.414 0L8 6.586 14.293.293a1 1 0 1 1 1.414 1.414L9.414 8l6.293 6.293a1 1 0 0 1-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 0 1-1.414-1.414L6.586 8 .293 1.707a1 1 0 0 1 0-1.414z'/%3e%3c/svg%3e) center/1em auto no-repeat;border:0;border-radius:.375rem;opacity:.5;}
        .btn-close:hover{color:#000;text-decoration:none;opacity:.75;}
        .btn-close:focus{outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);opacity:1;}
        .btn-close:disabled{pointer-events:none;-webkit-user-select:none;-moz-user-select:none;user-select:none;opacity:.25;}
        .btn-close-white{filter:invert(1) grayscale(100%) brightness(200%);}
        .toast{--bs-toast-padding-x:0.75rem;--bs-toast-padding-y:0.5rem;--bs-toast-spacing:1.5rem;--bs-toast-max-width:350px;--bs-toast-font-size:0.875rem;--bs-toast-bg:rgba(255, 255, 255, 0.85);--bs-toast-border-width:1px;--bs-toast-border-color:var(--bs-border-color-translucent);--bs-toast-border-radius:0.375rem;--bs-toast-box-shadow:0 0.5rem 1rem rgba(0, 0, 0, 0.15);--bs-toast-header-color:#6c757d;--bs-toast-header-bg:rgba(255, 255, 255, 0.85);--bs-toast-header-border-color:rgba(0, 0, 0, 0.05);width:var(--bs-toast-max-width);max-width:100%;font-size:var(--bs-toast-font-size);color:var(--bs-toast-color);pointer-events:auto;background-color:var(--bs-toast-bg);background-clip:padding-box;border:var(--bs-toast-border-width) solid var(--bs-toast-border-color);box-shadow:var(--bs-toast-box-shadow);border-radius:var(--bs-toast-border-radius);}
        .toast:not(.show){display:none;}
        .toast-header{display:flex;align-items:center;padding:var(--bs-toast-padding-y) var(--bs-toast-padding-x);color:var(--bs-toast-header-color);background-color:var(--bs-toast-header-bg);background-clip:padding-box;border-bottom:var(--bs-toast-border-width) solid var(--bs-toast-header-border-color);border-top-left-radius:calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));border-top-right-radius:calc(var(--bs-toast-border-radius) - var(--bs-toast-border-width));}
        .toast-header .btn-close{margin-right:calc(var(--bs-toast-padding-x) * -.5);margin-left:var(--bs-toast-padding-x);}
        .toast-body{padding:var(--bs-toast-padding-x);word-wrap:break-word;}
        .modal{--bs-modal-zindex:1055;--bs-modal-width:500px;--bs-modal-padding:1rem;--bs-modal-margin:0.5rem;--bs-modal-bg:#fff;--bs-modal-border-color:var(--bs-border-color-translucent);--bs-modal-border-width:1px;--bs-modal-border-radius:0.5rem;--bs-modal-box-shadow:0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);--bs-modal-inner-border-radius:calc(0.5rem - 1px);--bs-modal-header-padding-x:1rem;--bs-modal-header-padding-y:1rem;--bs-modal-header-padding:1rem 1rem;--bs-modal-header-border-color:var(--bs-border-color);--bs-modal-header-border-width:1px;--bs-modal-title-line-height:1.5;--bs-modal-footer-gap:0.5rem;--bs-modal-footer-border-color:var(--bs-border-color);--bs-modal-footer-border-width:1px;position:fixed;top:0;left:0;z-index:var(--bs-modal-zindex);display:none;width:100%;height:100%;overflow-x:hidden;overflow-y:auto;outline:0;}
        .modal-dialog{position:relative;width:auto;margin:var(--bs-modal-margin);pointer-events:none;}
        .modal.fade .modal-dialog{transition:transform .3s ease-out;transform:translate(0,-50px);}
        @media (prefers-reduced-motion:reduce){
            .modal.fade .modal-dialog{transition:none;}
        }
        .modal-content{position:relative;display:flex;flex-direction:column;width:100%;color:var(--bs-modal-color);pointer-events:auto;background-color:var(--bs-modal-bg);background-clip:padding-box;border:var(--bs-modal-border-width) solid var(--bs-modal-border-color);border-radius:var(--bs-modal-border-radius);outline:0;}
        .modal-header{display:flex;flex-shrink:0;align-items:center;justify-content:space-between;padding:var(--bs-modal-header-padding);border-bottom:var(--bs-modal-header-border-width) solid var(--bs-modal-header-border-color);border-top-left-radius:var(--bs-modal-inner-border-radius);border-top-right-radius:var(--bs-modal-inner-border-radius);}
        .modal-header .btn-close{padding:calc(var(--bs-modal-header-padding-y) * .5) calc(var(--bs-modal-header-padding-x) * .5);margin:calc(var(--bs-modal-header-padding-y) * -.5) calc(var(--bs-modal-header-padding-x) * -.5) calc(var(--bs-modal-header-padding-y) * -.5) auto;}
        .modal-title{margin-bottom:0;line-height:var(--bs-modal-title-line-height);}
        .modal-body{position:relative;flex:1 1 auto;padding:var(--bs-modal-padding);}
        .modal-footer{display:flex;flex-shrink:0;flex-wrap:wrap;align-items:center;justify-content:flex-end;padding:calc(var(--bs-modal-padding) - var(--bs-modal-footer-gap) * .5);background-color:var(--bs-modal-footer-bg);border-top:var(--bs-modal-footer-border-width) solid var(--bs-modal-footer-border-color);border-bottom-right-radius:var(--bs-modal-inner-border-radius);border-bottom-left-radius:var(--bs-modal-inner-border-radius);}
        .modal-footer>*{margin:calc(var(--bs-modal-footer-gap) * .5);}
        @media (min-width:576px){
            .modal{--bs-modal-margin:1.75rem;--bs-modal-box-shadow:0 0.5rem 1rem rgba(0, 0, 0, 0.15);}
            .modal-dialog{max-width:var(--bs-modal-width);margin-right:auto;margin-left:auto;}
        }
        @media (min-width:992px){
            .modal-lg{--bs-modal-width:800px;}
        }
        .modal-fullscreen{width:100vw;max-width:none;height:100%;margin:0;}
        .modal-fullscreen .modal-content{height:100%;border:0;border-radius:0;}
        .modal-fullscreen .modal-body{overflow-y:auto;}
        .clearfix::after{display:block;clear:both;content:"";}
        .fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030;}
        .fixed-bottom{position:fixed;right:0;bottom:0;left:0;z-index:1030;}
        .float-start{float:left!important;}
        .float-end{float:right!important;}
        .d-flex{display:flex!important;}
        .d-none{display:none!important;}
        .position-fixed{position:fixed!important;}
        .top-50{top:50%!important;}
        .start-50{left:50%!important;}
        .translate-middle{transform:translate(-50%,-50%)!important;}
        .border{border:var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;}
        .border-0{border:0!important;}
        .border-top{border-top:var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;}
        .border-top-0{border-top:0!important;}
        .border-end-0{border-right:0!important;}
        .border-bottom{border-bottom:var(--bs-border-width) var(--bs-border-style) var(--bs-border-color)!important;}
        .border-bottom-0{border-bottom:0!important;}
        .border-start-0{border-left:0!important;}
        .border-success{--bs-border-opacity:1;border-color:rgba(var(--bs-success-rgb),var(--bs-border-opacity))!important;}
        .border-light{--bs-border-opacity:1;border-color:rgba(var(--bs-light-rgb),var(--bs-border-opacity))!important;}
        .border-dark{--bs-border-opacity:1;border-color:rgba(var(--bs-dark-rgb),var(--bs-border-opacity))!important;}
        .border-white{--bs-border-opacity:1;border-color:rgba(var(--bs-white-rgb),var(--bs-border-opacity))!important;}
        .border-1{--bs-border-width:1px;}
        .flex-wrap{flex-wrap:wrap!important;}
        .justify-content-between{justify-content:space-between!important;}
        .m-1{margin:.25rem!important;}
        .m-2{margin:.5rem!important;}
        .m-3{margin:1rem!important;}
        .mx-2{margin-right:.5rem!important;margin-left:.5rem!important;}
        .mx-3{margin-right:1rem!important;margin-left:1rem!important;}
        .mx-auto{margin-right:auto!important;margin-left:auto!important;}
        .my-1{margin-top:.25rem!important;margin-bottom:.25rem!important;}
        .my-5{margin-top:3rem!important;margin-bottom:3rem!important;}
        .me-auto{margin-right:auto!important;}
        .mb-2{margin-bottom:.5rem!important;}
        .p-0{padding:0!important;}
        .fs-1{font-size:calc(1.375rem + 1.5vw)!important;}
        .fs-4{font-size:calc(1.275rem + .3vw)!important;}
        .fw-bolder{font-weight:bolder!important;}
        .text-start{text-align:left!important;}
        .text-center{text-align:center!important;}
        .text-decoration-none{text-decoration:none!important;}
        .text-decoration-underline{text-decoration:underline!important;}
        .text-success{--bs-text-opacity:1;color:rgba(var(--bs-success-rgb),var(--bs-text-opacity))!important;}
        .text-info{--bs-text-opacity:1;color:rgba(var(--bs-info-rgb),var(--bs-text-opacity))!important;}
        .text-danger{--bs-text-opacity:1;color:rgba(var(--bs-danger-rgb),var(--bs-text-opacity))!important;}
        .text-light{--bs-text-opacity:1;color:rgba(var(--bs-light-rgb),var(--bs-text-opacity))!important;}
        .text-white{--bs-text-opacity:1;color:rgba(var(--bs-white-rgb),var(--bs-text-opacity))!important;}
        .bg-dark{--bs-bg-opacity:1;background-color:rgba(var(--bs-dark-rgb),var(--bs-bg-opacity))!important;}
        .bg-black{--bs-bg-opacity:1;background-color:rgba(var(--bs-black-rgb),var(--bs-bg-opacity))!important;}
        .rounded-circle{border-radius:50%!important;}
        @media (min-width:768px){
            .d-md-block{display:block!important;}
            .d-md-none{display:none!important;}
            .order-md-1{order:1!important;}
            .order-md-2{order:2!important;}
        }
        @media (min-width:1200px){
            .fs-1{font-size:2.5rem!important;}
            .fs-4{font-size:1.5rem!important;}
        }
        *::-webkit-scrollbar{width:5px;}
        *::-webkit-scrollbar-track{background:#000000;}
        *::-webkit-scrollbar-thumb{background-color:#ffffff;border-radius:3px;border:0 none #000000;}
        .font1{font-family:'Concert One', cursive;}
        .font5{font-family:'Permanent Marker', cursive;}
        .font6{font-family:'Special Elite', cursive;}
        .containera{position:relative;margin-left:auto;margin-right:auto;text-align:center;width:300px;height:auto;color:white;}
        body{padding-top:3rem;padding-bottom:3rem;color:#5a5a5a;}
        .marketing .col-lg-4{margin-bottom:1.5rem;text-align:center;}
        .marketing h2{font-weight:400;}
        .marketing .col-lg-4 p{margin-right:.75rem;margin-left:.75rem;}
        .featurette-divider{margin:5rem 0;}
        .featurette-heading{font-weight:300;line-height:1;letter-spacing:-.05rem;}
        @media (min-width: 40em){
            .featurette-heading{font-size:50px;}
        }
        @media (min-width: 62em){
            .featurette-heading{margin-top:7rem;}
        }
        @media all{
            .fa-regular{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:var(--fa-display,inline-block);font-style:normal;font-variant:normal;line-height:1;text-rendering:auto;}
            .fa-bars:before{content:"\f0c9";}
            .fa-circle-question:before{content:"\f059";}
            .fa-heart:before{content:"\f004";}
            .fa-house-blank:before{content:"\e487";}
            .fa-user-check:before{content:"\f4fc";}
            .fa-user-plus:before{content:"\f234";}
            .fa-regular{font-family:"Font Awesome 6 Pro";font-weight:400;}
        }
</style>
</head>
<body class="bg-black text-light">
<?php require_once RootDir."includes/top.php"; ?>
<main>
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing my-5">
        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-4">
                <img src="/assets/img/Leandro - home.webp" width="150" height="150"
                     class="rounded-circle mx-3 border border-1 border-white">

                <h2>Comece criando sua conta</h2>
                <p>Crie suas fichas, mestre as suas missões tudo isso de forma GRATIS!</p>
                <button class="btn btn-outline-success font1" data-bs-toggle="modal" data-bs-target="#cadastrar">Criar conta</button>
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <h3 class="text-info ">Clique abaixo para testar!</h3>
                <div class="container-fluid p-0 mb-2" style="zoom: 75%;">
                    <div class="containera mx-auto text-white">
                    </div>
                </div>
            </div><!-- /.col-lg-4 -->

            <div class="col-lg-4">
                    <img src="/assets/img/foto.webp" width="150" height="150"
                         class="bg-dark rounded-circle mx-3 border border-1 border-white">
                    <h2>Comunidade</h2>
                <p>Entre no nosso discord e entre na nossa comunidade de ordem</p>
                <a class="btn btn-outline-primary font1" href="https://discord.gg/gHaAxqC2Hw">Discord</a>
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->

        <!-- START THE FEATURETTES -->
        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">UI Limpa e minimalista</h2>
                <p class="lead">Tudo isso para você se sentir o mais confortavel.</p>
            </div>
            <div class="col-md-5">
                <img src="/assets/img/pericias.webp" width="500" height="500"
                     class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">
            </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading">Não tem como errar</h2>
                <p class="lead">tudo é bem autoexplicativo e pensado em ajudar-lhe a usar.</p>
            </div>
            <div class="col-md-5 order-md-1">
                <img src="/assets/img/principal.webp" width="500" height="500"
                     class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">
            </div>
        </div>
        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">E por fim...</h2>
                <p class="lead">Não tem como deixar o principal de lado, sistema de rolar dados completissimo para você.</p>
            </div>
            <div class="col-md-5">
                <video src="/assets/img/rolar.webm" preload="none" width="500" height="500" playsinline autoplay
                       muted loop
                       class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto">

            </div>
        </div>
    </div>
</main>

<footer class="container-fluid fixed-bottom text-white border-light border-top">
    <div class="clearfix">
        <div class="float-start text-start">
            <a href="https://getbootstrap.com/" class="text-decoration-none">
                <img src="assets/img/bootstrap-logo.svg" height="25" width="32" alt="..."/>Bootstrap.
            </a>
        </div>
    </div>
</footer>
<?php require_once RootDir."sessao/include_geral/modal_dice.php"; ?>
<?php require_once RootDir."includes/scripts.php"; ?>
<?php require_once RootDir."sessao/include_geral/scripts.php"; ?>
</body>
</html>