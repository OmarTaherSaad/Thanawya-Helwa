@extends('layouts.app')
@section('title','اختبار هيرمان لتحليل الشخصية')
@section('head')
    <style>
        svg {
            transform-origin: top center;
            -webkit-transform-origin: top center;
            display: block;
            margin: auto;
        }
    </style>
@endsection
@section('content')
<div id="edgesApp">
    <div class="row">
        <div class="col-10 col-md-8">
            <h4>اختبار تحليل الشخصية</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-10" id="msform">
            <v-stepper v-model="activeSection" vertical>
                    <template v-for="n in sectionCount">
                        <v-stepper-step :key="`${n}-step`" :complete="activeSection > n" :step="n">
                            مرحلة @{{ n }}
                        </v-stepper-step>
            
                        <v-stepper-content :key="`${n}-content`" :step="n">
                            <div v-for="i in range(1 + (n-1)*chunkSize, n * chunkSize)" class="form-group" v-if="indexExist(i)">
                                <label>@{{ i + '- ' + questions['Question'+i].Question }}</label>
                                <select :class="questions['Question'+i].Class" @change="getClass('Question'+i)"
                                    v-model.number="questions['Question'+i].Answer">
                                    <option value="0">أبدًا</option>
                                    <option value="1">نادرًا</option>
                                    <option value="2">أحيانًا</option>
                                    <option value="3">غالبًا</option>
                                    <option value="4">دومًا</option>
                                </select>
                            </div>
                            <button v-if="n != sectionCount" class="btn btn-primary" type="button" @click="nextStep(n)">التالي</button>
                            <button v-if="n == sectionCount" class="btn btn-primary" type="button" @click="submit">النتيجة</button>
                        </v-stepper-content>
                    </template>
            </v-stepper>
        </div>
    </div>
    <div class="row justify-content-center" v-if="result.A != null">
        <div class="col-12 col-md-6 text-center">
            <div class="alert alert-success" role="alert">
                <h4>@{{ chartLabels.A + ': ' + result.A }}</h4>
                <h4>@{{ chartLabels.B + ': ' + result.B }}</h4>
                <h4>@{{ chartLabels.C + ': ' + result.C }}</h4>
                <h4>@{{ chartLabels.D + ': ' + result.D }}</h4>
            </div>
        </div>
    </div>
    <div class="row" v-if="result.A != null">
        <div class="col-12 h-100">
            <svg ref="chart" width="60" height="60" transform="scale(5 5)" viewBox="-30 -30 60 85">
                <circle cx="0" cy="0" r="30" stroke="black" stroke-width="0.1" fill="white"></circle>
                {{-- X-axis --}}
                <line x1="-30" y1="0" x2="30" y2="0" stroke-width="0.2" stroke="black"></line>
                {{-- Y-axis --}}
                <line x1="0" y1="-30" x2="0" y2="30" stroke-width="0.2" stroke="black"></line>
                {{-- Quad background --}}
                <path d="M 0 -30 A 30 30 0 0 0 -30 0 L 0 0 Z" fill="yellow"></path>
                <path d="M 30 0 A 30 30 0 0 0 0 -30 L 0 0 Z" fill="blue"></path>
                <path d="M -30 0 A 30 30 0 0 0 0 30 L 0 0 Z" fill="green"></path>
                <path d="M 0 30 A 30 30 0 0 0 30 0 L 0 0 Z" fill="red"></path>
                {{-- Quad Letters --}}
                <text x="15" y="-10" fill="black">D</text>
                <text x="-10" y="-10" fill="white">A</text>
                <text x="15" y="15" fill="black">C</text>
                <text x="-10" y="15" fill="white">B</text>
                <polygon ref="polygon" stroke="black" fill="transparent" stroke-width="1" :points="points"></polygon>
            </svg>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ mix('js/herman.js') }}"></script>
@endsection