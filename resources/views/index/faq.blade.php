@extends('layouts.index')
@section('title') সচরাচর জিজ্ঞাসা | BCS Exam AID | বিসিএস-সহ সরকারি চাকরি পরীক্ষা প্রস্তুতির জন্য সেরা অনলাইন প্ল্যাটফর্ম @endsection

@section('third_party_stylesheets')
<style>
    :root {
        --primary-color: #0062cc; /* আপনার ব্র্যান্ড কালার অনুযায়ী পরিবর্তন করতে পারেন */
    }
    .faq-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .faq-header h2 {
        font-weight: 700;
        color: #333;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    .faq-header h2::after {
        content: '';
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    .accordion-item {
        border: none;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        border-radius: 8px !important;
        overflow: hidden;
    }
    .accordion-button {
        font-weight: 600;
        color: #444;
        padding: 20px;
        background-color: #fff;
    }
    .accordion-button:not(.collapsed) {
        background-color: var(--primary-color);
        color: #fff;
        box-shadow: none;
    }
    .accordion-button:focus {
        box-shadow: none;
    }
    .accordion-body {
        padding: 20px;
        line-height: 1.8;
        color: #555;
        background-color: #fff;
    }
    .highlight-box {
        background: #f0f7ff;
        border-left: 4px solid var(--primary-color);
        padding: 15px;
        margin-top: 10px;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<section style="padding-top: 150px; padding-bottom: 80px; background-color: var(--light-3);">
    <div class="container">
        <div class="faq-header">
            <h2>সচরাচর জিজ্ঞাসাগুলো (FAQ)</h2>
            <p class="mt-3 text-muted">আপনার মনে থাকা সাধারণ প্রশ্নগুলোর উত্তর এখানে পাবেন</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="bcsFaq">
                    
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                                ১. BCS Exam Aid অ্যাপটি আসলে কী এবং কাদের জন্য?
                            </button>
                        </h3>
                        <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#bcsFaq">
                            <div class="accordion-body">
                                <strong>BCS Exam Aid</strong> হলো বিসিএস প্রিলিমিনারি, ব্যাংক, প্রাইমারি এবং জুডিশিয়ারিসহ যেকোনো সরকারি চাকরির প্রস্তুতির জন্য একটি স্বয়ংসম্পূর্ণ ডিজিটাল লার্নিং প্ল্যাটফর্ম। আপনি দেশের যেকোনো প্রান্ত থেকে অনলাইনে ১ লক্ষাধিক প্রশ্নের বিশাল ভাণ্ডারে অ্যাক্সেস পাবেন। এখানে বিষয়ভিত্তিক লাইভ পরীক্ষা দিয়ে প্রতিদিন হাজারো পরীক্ষার্থীর মাঝে নিজের মেধা যাচাই করার সুযোগ রয়েছে। মূলত যারা ঘরে বসে নির্ভুল ও আধুনিক স্মার্ট প্রস্তুতি নিতে চান, তাদের জন্যই এই অ্যাপ।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
                                ২. আমি এখনো ছাত্র, বিসিএস প্রস্তুতির জন্য এখনই কী করা উচিত?
                            </button>
                        </h3>
                        <div id="q2" class="accordion-collapse collapse" data-bs-parent="#bcsFaq">
                            <div class="accordion-body">
                                বিসিএস বর্তমানে অত্যন্ত প্রতিযোগিতামূলক। ছাত্রাবস্থায় প্রস্তুতি শুরু করা একটি বুদ্ধিদীপ্ত সিদ্ধান্ত। আপনার জন্য পরামর্শ:
                                <ul>
                                    <li><strong>গণিত ও ইংরেজি:</strong> বেসিক স্ট্রং করতে নিয়মিত চর্চা করুন।</li>
                                    <li><strong>সাধারণ জ্ঞান:</strong> প্রতিদিন বাংলা ও ইংরেজি পত্রিকা পড়ার অভ্যাস করুন।</li>
                                    <li><strong>সাহিত্য ও ইতিহাস:</strong> মুক্তিযুদ্ধভিত্তিক বই এবং ক্লাসিক বাংলা সাহিত্য (রবীন্দ্রনাথ, শরৎচন্দ্র) পড়ুন।</li>
                                    <li><strong>ইউটিউব ও মুভি:</strong> ইংরেজি শোনার দক্ষতা বাড়াতে TED Talk বা ইংলিশ মুভি দেখতে পারেন।</li>
                                </ul>
                                <p class="highlight-box">অনার্স শেষ হওয়ার আগ পর্যন্ত এই মৌলিক বিষয়গুলোতে দক্ষ হয়ে উঠলে পরবর্তীতে বিসিএস সিলেবাস শেষ করা আপনার জন্য অনেক সহজ হবে।</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3">
                                ৩. অ্যাপটি ব্যবহার করে কীভাবে আমি সবচেয়ে ভালো ফলাফল পাব?
                            </button>
                        </h3>
                        <div id="q3" class="accordion-collapse collapse" data-bs-parent="#bcsFaq">
                            <div class="accordion-body">
                                প্রস্তুতির কার্যকারিতা বাড়াতে আমাদের অ্যাপের <strong>"Topic-based Exam"</strong> সেকশনটি সবচেয়ে কার্যকর। আপনি যে অধ্যায়টি পড়বেন, সাথে সাথে অ্যাপে ঢুকে সেই টপিকের ওপর পরীক্ষা দিন। যে প্রশ্নগুলো ভুল করছেন, সেগুলো <strong>'Mark for Review'</strong> করে রাখুন এবং পরবর্তীতে রিভিশন দিন। এছাড়া নিয়মিত লাইভ মক টেস্টে অংশগ্রহণ করে নিজের অবস্থান যাচাই করুন এবং আমাদের আর্কাইভ থেকে পুরনো প্রশ্নগুলো সলভ করুন।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q4">
                                ৪. চাকরির পাশাপাশি কীভাবে পড়ার সময় বের করব?
                            </button>
                        </h3>
                        <div id="q4" class="accordion-collapse collapse" data-bs-parent="#bcsFaq">
                            <div class="accordion-body">
                                যারা পেশাজীবী বা ব্যস্ত থাকেন, তাদের কথা মাথায় রেখে আমরা ডিজাইন করেছি <strong>‘বিসিএস প্রস্তুতি (৬ মাস)’</strong> বিশেষ কোর্স। এই রুটিনে দৈনিক মাত্র ২-৩ ঘণ্টা সময় দিলেই আপনি পুরো সিলেবাস গুছিয়ে নিতে পারবেন। আমাদের অ্যাপের ‘লেকচার অ্যান্ড নোটস’ অপশনে গিয়ে বিশেষ গাইডলাইনগুলো অনুসরণ করলে চাকরির পাশাপাশি আপনি অন্যদের চেয়ে অনেক এগিয়ে থাকবেন।
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q5">
                                ৫. অনেক চেষ্টা করেও ভালো রেজাল্ট আসছে না, এখন আমার করণীয় কী?
                            </button>
                        </h3>
                        <div id="q5" class="accordion-collapse collapse" data-bs-parent="#bcsFaq">
                            <div class="accordion-body">
                                বিসিএস হলো ধৈর্যের পরীক্ষা। প্রচুর পড়ার পাশাপাশি কৌশলী হতে হবে। নিয়মিত মডেল টেস্ট দেওয়ার কোনো বিকল্প নেই। আপনি যত বেশি পরীক্ষা দেবেন, আপনার ভুল করার প্রবণতা তত কমে আসবে। ভুল হওয়া প্রশ্নগুলো নিয়ে আলাদাভাবে কাজ করুন এবং সেগুলো বারবার রিভিশন দিন। সঠিক গাইডলাইন এবং ধারাবাহিকতা বজায় রাখলে সাফল্য নিশ্চিত।
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('third_party_scripts')
@endsection