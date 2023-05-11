<!DOCTYPE html>
<html>

<head>
    <title>{{ $appointment->id }}</title>
   
    <style>
       
       
        body {
            margin: 0;
            padding: 0;
            /* font-family: 'kalpurush', sans-serif; */
        }

        /* Styles go here */

        .page-header,
        .page-header-space {
            height: 132px;
        }

        .page-footer,
        .page-footer-space {
            height: 30px;

        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            /* for demo */
        }

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            /* for demo */
            /* for demo */
        }

        /* report style */
        header {
            border: 1px solid #000;
            display: none;
        }

        footer {
            border: 1px solid #000;
            text-align: center;
            display: none;
        }

        .m-0 {
            margin: 0;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .p-0 {
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        pre {
            white-space: pre-line;
        }

        /* end report style */

        @page {
            size: A4;
            page-break-after: always;
            margin: 15px;
        }

        @media print {
            header {
                display: block;
            }

            footer {
                display: block;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            button {
                display: none;
            }

            body {
                margin: 0;
            }
        }

    </style>
</head>

<body>
    <div class="page-header" style="text-align: center">
        <header style="width:21cm; margin:0 auto;">
            <table width="100%">
                <tr>
                    <td style="text-align: center">
                        <h2 class="m-0">Khwaja Yunus Ali Medical College & Hospital</h2>
                        <p class="m-0">FOUNDER DR. M. M. AMJAD HUSSAIN</p>
                    </td>
                </tr>
            </table>
            <table width="100%" style="font-size: 14px; text-align:left;">
                <tr>
                    <td width="50%">
                        <p class="m-0 p-0" style="text-transform: uppercase; font-weight:bold;">
                            {{ $appointment->doctor->name }}</p>
                        <p class="m-0 p-0">{{ $appointment->doctor->degree }}</p>
                        <p class="m-0 p-0">{{ $appointment->doctor->designation }}</p>
                        <p class="m-0 p-0">{{ $appointment->doctor->department }}</p>
                        <p class="m-0 p-0">BMDC Reg No.: {{ $appointment->doctor->reg_no }}</p>
                    </td>

                    <td width="50%">
                        <table>
                            <tr>
                                <td width="50px">Name</td>
                                <td width="5px">:</td>
                                <td colspan="4">{{ $appointment->patient->name }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td width="110px">
                                    {{ $appointment->patient->gender}}
                                </td>
                                <td width="75px">Age</td>
                                <td width="5px">:</td>
                                <td>{{ $appointment->patient->age_years .'Y ' .$appointment->patient->age_months .'M ' .$appointment->patient->age_days .'D' }}
                                </td>
                            </tr>
                            <tr>
                                <td>HN</td>
                                <td>:</td>
                                <td>{{ $appointment->patient->registration_no }}</td>
                                <td>Blood Group</td>
                                <td>:</td>
                                <td>{{ $appointment->patient->bloodgroup }}
                                </td>
                            </tr>
                            <tr>
                                <td>CN</td>
                                <td>:</td>
                                <td>{{ $appointment->cn }}</td>
                                <td>App. Date</td>
                                <td>:</td>
                                <td>{{ $appointment->appointment_date }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </header>
    </div>

    <div class="page-footer">
        <footer style="width:21cm; height:28px; margin:0 auto;">
            Khwaja Yunus Ali Medical College & Hospital, Enayetpur, Sirajganj, Bangladesh
        </footer>
    </div>

    <table>

        <thead>
            <tr>
                <td>
                    <!--place holder for the fixed-position header-->
                    <div class="page-header-space"></div>
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <!--*** CONTENT GOES HERE ***-->
                    <main style="width: 21cm; word-wrap: break-word; margin: 0 auto;">
                        <table style="border: 1px solid #000;">
                            <tr>
                                <td width="50%" style="line-height:0;">
                                    <img style="    width: 145px; height: 30px; padding: 5px;"
                                        src="data:image/png;base64,{{ DNS1D::getBarcodePNG($appointment->patient->registration_no, 'C128') }}"
                                        alt="barcode" />
                                </td>
                                <td width="50%" style="text-align: right; line-height:0;">
                                    <img style="    width: 145px; height: 30px; padding: 5px;"
                                        src="data:image/png;base64,{{ DNS1D::getBarcodePNG($appointment->appointment_no, 'C128') }}"
                                        alt="barcode" />
                                </td>
                            </tr>
                        </table>

                        <div style=" display: flex; justify-content: space-between; min-height: 350px; ">
                            <div style=" width: 50%; border: 1px solid #ddd; ">
                                <table>
                                    <tr>
                                        <td style="border: 1px solid #000;">Temp.</td>
                                        <td style="border: 1px solid #000;">PR/min</td>
                                        <td style="border: 1px solid #000;">RR/min</td>
                                        <td style="border: 1px solid #000;">BP mmHG</td>
                                        <td style="border: 1px solid #000;">Weight</td>
                                        <td style="border: 1px solid #000;">Height</td>
                                        <td style="border: 1px solid #000;">OFC</td>
                                        <td style="border: 1px solid #000;">SaO2</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #000;">{{ $appointment->temperature }}</td>
                                        <td style="border: 1px solid #000;">{{ $appointment->pulse_rate }}</td>
                                        <td style="border: 1px solid #000;">{{ $appointment->respiratory_rate }}</td>
                                        <td style="border: 1px solid #000;">
                                            {{ $appointment->bp_systolic }}/{{ $appointment->bp_diastolic }}</td>
                                        <td style="border: 1px solid #000;">{{ $appointment->weight }}</td>
                                        <td style="border: 1px solid #000;">{{ $appointment->height }}</td>
                                        <td style="border: 1px solid #000;">{{ $appointment->ofc }}</td>
                                        <td style="border: 1px solid #000;">{{ $appointment->sao2 }}</td>
                                    </tr>
                                </table>

                                @if ($appointment->case_summary)
                                    <p class="m-0 p-0 mt-5" style="text-decoration:underline; font-weight:bold;">Case
                                        Summary:</p>
                                    <pre class="m-0 p-0" style="font-family:Arial; margin-left:10px;">{{ $appointment->case_summary }}</pre>
                                @endif

                                @if ($appointment->chief_complaints)
                                    <p class="m-0 p-0 mt-5" style="text-decoration:underline; font-weight:bold;">Chief
                                        Complaint:</p>
                                    <pre class="m-0 p-0" style="font-family:Arial; margin-left:10px;">{{ $appointment->chief_complaints }}</pre>
                                @endif

                                @if ($appointment->diagnosis)
                                    <p class="m-0 p-0 mt-5" style="text-decoration:underline; font-weight:bold;">
                                        Diagnosis:</p>
                                    <pre class="m-0 p-0" style="font-family:Arial; margin-left:10px;">{{ $appointment->diagnosis }}</pre>
                                @endif

                                @if ($appointment->procedure)
                                    <p class="m-0 p-0 mt-5" style="text-decoration:underline; font-weight:bold;">
                                        Procedure / Plan:</p>
                                    <pre class="m-0 p-0" style="font-family:Arial; margin-left:10px;">{{ $appointment->procedure }}</pre>
                                @endif

                            </div>
                            <div style=" width: 50%; border: 1px solid #ddd; ">
                                <h1 class="m-0 p-0" style="font-size: 17px; text-decoration:underline;">RX</h1>
                                <ol>
                                    @foreach ($appointment->medications as $medication)
                                        <li>
                                            <p class="m-0 p-0"
                                                style="font-weight: bold; text-decoration:underline;">
                                                {{ $medication->medicine }}</p>
                                            <small
                                                style="display:block; margin-bottom:10px;">{{ $medication->instruction .', ' .$medication->note .' (' .$medication->dose .') - ' .$medication->duration }}</small>
                                        </li>
                                    @endforeach
                                </ol>


                            </div>
                        </div>

                        <table>
                            <tr>
                                <td>
                                    @if ($appointment->investigations)
                                    <p class="m-0 p-0" style="text-decoration:underline; font-weight:bold;">
                                        Investigation:</p>
                                    <pre class="m-0 p-0" style="font-family:Arial; margin-left:10px;">{{ $appointment->investigations }}</pre>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if ($appointment->doctor->signature)
                                        <img style="width: 100px;" src="{{ asset($appointment->doctor->signature) }}"
                                            alt="">
                                    @endif

                                    <p class="m-0 p-0" style="font-weight:bold; border-top: 1px solid #000;">
                                        {{ $appointment->doctor->name }}</p>

                                </td>
                            </tr>
                        </table>

                        <p class="m-0 p-0" style="text-decoration:underline; font-weight:bold;">Advice:</p>
                        <pre class="m-0 p-0" style="font-family:Arial; margin-left:10px;">{{ $appointment->advice }}</pre>

                    </main>
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td>
                    <!--place holder for the fixed-position footer-->
                    <div class="page-footer-space"></div>
                </td>
            </tr>
        </tfoot>

    </table>
    <script>
        // window.onload = function() {
        //     window.print();
        //     window.onafterprint = function() {
        //         window.close()
        //     };
        // }
    </script>
</body>


</html>