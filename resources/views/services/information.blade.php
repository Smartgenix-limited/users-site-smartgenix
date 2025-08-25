@extends('layouts.app')

@section('content')
    <div class="container page-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center p-1">
                        <h4 class="pt-2">Services Informations</h4>
                    </div>
                    <div class="card-body">
                        <h3>How often should you service your car?</h3>
                        <p>It is recommended that your car receives a full service <span
                                class="text-danger fw-semibold">every 12,000
                                miles</span> or every <span class="text-danger fw-semibold">12 months</span> - whichever
                            comes sooner.
                        </p>
                        <p>More general check-ups, such as our Engine Oil and Filter Change and Interim Servicing options,
                            are also available to ensure your vehicle is kept in the best possible condition. </p>
                        <div class="table-responsive mb-2">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 30%">Service Type</th>
                                        <th scope="col">Service Interval</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="width: 30%">Interim Service</td>
                                        <td>Every 6 months or 6,000 miles (whichever comes first)</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">Full Service</td>
                                        <td>Every 12 months or 12,000 miles (whichever comes first)</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">Major Service</td>
                                        <td>As per manufacturer service schedule</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>Regular servicing can help to keep your car running smoothly and identify potential problems
                            early on, reducing the risk of more serious and costly problems in the future.</p>
                        <p> Most importantly, regular car servicing is a fundamental step in helping to keep you and your
                            loved ones safe on the roads.</p>
                        <h3>What's included in my service?</h3>
                        <p class="fw-semibold">At Smartgenix we offer a range of servicing options to meet your
                            driving needs.</p>
                        <p>We have a range of affordable service packages to suit your needs, whether you are looking for a
                            full service as part of an annual servicing schedule or an interim car health check to keep your
                            vehicle in the best condition and maintain optimum performance. </p>
                        <p>Vehicle servicing is carried out by highly trained service technicians and use parts that match
                            the quality of the manufacturer’s original equipment. We offer a genuine alternative to dealer
                            servicing so why pay more?</p>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    @php
                                        $currency = support_setting('currency_symbol');
                                    @endphp
                                    <tr class="text-center">
                                        <th scope="col" colspan="3">Service Table What is included in each Service we
                                            offer and Price (Subject to change)</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Interim</th>
                                        <th scope="col">Full</th>
                                        <th scope="col">Major</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">{{ $currency }}{{ setting('interm_service') }}</th>
                                        <th scope="col">{{ $currency }}{{ setting('full_service') }}</th>
                                        <th scope="col">{{ $currency }}{{ setting('major_service') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Check instruments, gauges, warning lights</td>
                                        <td>Check instruments, gauges, warning lights</td>
                                        <th>Full + As recommended by the dealer</th>
                                    </tr>
                                    <tr>
                                        <td>Check horn</td>
                                        <td>Check horn</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check windscreen wipers</td>
                                        <td>Check windscreen wipers</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check Adblue/Eolys warning light</td>
                                        <td>Check Adblue/Eolys warning light</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check interior lights</td>
                                        <td>Check interior lights</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check clutch operation (manual only)</td>
                                        <td>Check clutch operation (manual only)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check seat belts</td>
                                        <td>Check seat belts</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Reset service light</td>
                                        <td>Reset service light</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check climate control/ air con system </td>
                                        <td>Check climate control/ air con system </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check engine diagnostic codes</td>
                                        <td>Check engine diagnostic codes</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Hybrid system diagnostic check (hybrid only)</td>
                                        <td>Hybrid system diagnostic check (hybrid only)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check exterior lights & lamps</td>
                                        <td>Check exterior lights & lamps</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check doors - operation and condition</td>
                                        <td>Check doors - operation and condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check boot - operation and condition</td>
                                        <td>Check boot - operation and condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check fuel cap - operation and condition</td>
                                        <td>Check fuel cap - operation and condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check steering, suspension linkages and ball joints for wear, damage and
                                            condition</td>
                                        <td>Check mirrors - operation and condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Suspension - check shock absorbers & springs</td>
                                        <td>Check Adblue/Eolys warning light</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Full tyre inspection (tread, pressure and alignment check) </td>
                                        <td>Check interior lights</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>TPMS inspection</td>
                                        <td>Check clutch operation (manual only)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check battery </td>
                                        <td>Check seat belts</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check battery wiring</td>
                                        <td>Reset service light</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Test electrics (battery, alternator, starter motor)</td>
                                        <td>Check climate control/ air con system </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check coolant level (strength and condition)</td>
                                        <td>Check engine diagnostic codes</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check coolant level (strength and condition)</td>
                                        <td>Check engine diagnostic codes</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Inverter Coolant - strength and condition (hybrid only)</td>
                                        <td>Hybrid system diagnostic check (hybrid only)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Visual inspection of high voltage cables for external damage (hybrid only)</td>
                                        <td>Check exterior lights & lamps</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check brake fluid (boiling point and condition)</td>
                                        <td>Check doors - operation and condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check bonnet catch operation</td>
                                        <td>Check boot - operation and condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Check brake pipes & hoses</td>
                                        <td>Check fuel cap - operation and condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Visual brake check</td>
                                        <td>Check mirrors - operation and condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Replace engine oil and filter</td>
                                        <td>Check steering, suspension linkages and ball joints for wear, damage and
                                            condition</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Top up windscreen washer fluid</td>
                                        <td>Suspension - check shock absorbers & springs</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Vehicle road test</td>
                                        <td>Full tyre inspection (tread, pressure and alignment check) </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Stamp service book</td>
                                        <td>TPMS inspection</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check battery</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check battery wiring</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Test electrics (battery, alternator, starter motor)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Inverter Coolant - strength and condition (hybrid only)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Visual inspection of high voltage cables for external damage (hybrid only)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check brake fluid (boiling point and condition)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check bonnets catch operation</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check brake pipes & hoses</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check power steering fluid & top up (if required)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check auxiliary drive belt and adjust (if required)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check radiator and coolant hoses</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Visual brake check</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Full brake inspection </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check fuel pipes for routing, damage & corrosion</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check engine, transmission and rear axle Train Drive</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check drive shaft joints and gaiters for wear and damage</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Check exhaust system and mountings</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Replace engine oil and filter</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Top up windscreen washer fluid</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Replace air filter</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Vehicle road test </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Stamp service book</td>
                                        <td></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
