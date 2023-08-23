@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row text-center">
        <div class="col-md-6">
            <h2>Donate</h2>
            <p>
                Visit our JustGiving page to directly donate to the Team or create a fundraiser in our name to share with your friends and family.
                To find out more
                <a href="https://www.justgiving.com/penrith-mountainrescue">click here</a>
            </p>
            <div>
                <a
                    href="https://link.justgiving.com/v1/charity/donate/charityId/779549?tipScheme=TipJar2.1&amp;amount=20.00&amp;exitUrl=https%3A%2F%2Fwww.penrithmrt.org.uk%2Fthank-you&amp;reference=Website"
                    target="_blank"
                    rel="noopener noreferrer"
                    style="display: flex; flex-direction: column; align-items: center; width: 100%; max-width: 296px; min-width: 256px; margin: 12px auto;"
                >
                    <span style="display: flex; align-items: center; justify-content: center; width: 100%; height: 48px; background-color: #aa2ab5; border-radius: 3px; margin-bottom: 12px;">
                        <img src="https://www.jg-cdn.com/buttons/donate-with-jg.svg" alt="Donate with JustGiving.">
                    </span>
                    <img src="https://www.jg-cdn.com/buttons/payment-type-logos.svg" alt="Pay with Mastercard, Visa, American express, PayPal, Apple Pay or Direct Debit.">
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <h2>Legacies and Wills</h2>
            <p>
                Putting a gift in your Will to Penrith Mountain Rescue helps us plan for our future. It helps provide the training, skills and equipment our members need to keep themselves and the casualties safe - delivering help and medical assistance where it's needed to those lost and injured in the hills. No matter the size of your gift, it will help!
            </p>
        </div>
    </div>
    <div class="row text-center my-2">
        <div class="col-md-6">
            <h2>Social Media</h2>
            <p>Donate directly to Penrith Mountain Rescue Teams Facebook page or set up a fundraiser in our name. 100% of your donations come to the Team. Social media is a great way to share and show your support with family and friends.</p>
            <a href="https://www.facebook.com/PenrithMRT" target="_blank" aria-label="Facebook">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
                    </svg>
            </a>
            <a href="https://www.instagram.com/penrithmountainrescue/" target="_blank" aria-label="Instragram">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path d="M14.829 6.302c-.738-.034-.96-.04-2.829-.04s-2.09.007-2.828.04c-1.899.087-2.783.986-2.87 2.87-.033.738-.041.959-.041 2.828s.008 2.09.041 2.829c.087 1.879.967 2.783 2.87 2.87.737.033.959.041 2.828.041 1.87 0 2.091-.007 2.829-.041 1.899-.086 2.782-.988 2.87-2.87.033-.738.04-.96.04-2.829s-.007-2.09-.04-2.828c-.088-1.883-.973-2.783-2.87-2.87zm-2.829 9.293c-1.985 0-3.595-1.609-3.595-3.595 0-1.985 1.61-3.594 3.595-3.594s3.595 1.609 3.595 3.594c0 1.985-1.61 3.595-3.595 3.595zm3.737-6.491c-.464 0-.84-.376-.84-.84 0-.464.376-.84.84-.84.464 0 .84.376.84.84 0 .463-.376.84-.84.84zm-1.404 2.896c0 1.289-1.045 2.333-2.333 2.333s-2.333-1.044-2.333-2.333c0-1.289 1.045-2.333 2.333-2.333s2.333 1.044 2.333 2.333zm-2.333-12c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.958 14.886c-.115 2.545-1.532 3.955-4.071 4.072-.747.034-.986.042-2.887.042s-2.139-.008-2.886-.042c-2.544-.117-3.955-1.529-4.072-4.072-.034-.746-.042-.985-.042-2.886 0-1.901.008-2.139.042-2.886.117-2.544 1.529-3.955 4.072-4.071.747-.035.985-.043 2.886-.043s2.14.008 2.887.043c2.545.117 3.957 1.532 4.071 4.071.034.747.042.985.042 2.886 0 1.901-.008 2.14-.042 2.886z"/>
                    </svg>
            </a>
            <a href="https://twitter.com/PenrithMRT" target="_blank" class="sqs-svg-icon--wrapper twitter-unauth" aria-label="Twitter">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm6.066 9.645c.183 4.04-2.83 8.544-8.164 8.544-1.622 0-3.131-.476-4.402-1.291 1.524.18 3.045-.244 4.252-1.189-1.256-.023-2.317-.854-2.684-1.995.451.086.895.061 1.298-.049-1.381-.278-2.335-1.522-2.304-2.853.388.215.83.344 1.301.359-1.279-.855-1.641-2.544-.889-3.835 1.416 1.738 3.533 2.881 5.92 3.001-.419-1.796.944-3.527 2.799-3.527.825 0 1.572.349 2.096.907.654-.128 1.27-.368 1.824-.697-.215.671-.67 1.233-1.263 1.589.581-.07 1.135-.224 1.649-.453-.384.578-.87 1.084-1.433 1.489z"/>
                    </svg>
            </a>
        </div>
        <div class="col-md-6">
            <h2>Fundraise</h2>
            <p>It all begins with an idea. Create a local or online fundraiser in your own unique way. You can then donate your raised funds through our Social links/JustGiving or contact us and we can provide you with the Teams BACs details.</p>
        </div>
    </div>
</div>
@endsection