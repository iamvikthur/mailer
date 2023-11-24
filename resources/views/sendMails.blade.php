@extends('layouts.home')

@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Send bulk Emails</h1>
    <p class="mb-4">Past a comma seperated list of emails here to send them emails one after another.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Comma Seperated Emails</h6>
        </div>
        <div class="card-body">
            @if (session()->has("success"))
                <div class="alert alert-success">Success: Mails have been queued for sending</div>
            @endif
            <form action="{{ route('mails.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="commaSeperatedTextarea" class="form-label">Paste Emails</label>
                    <textarea rows="10" name="emails" required cols="10" class="form-control" id="commaSeperatedTextarea" placeholder="test@test.com,big@small.com,new@abcd.com" rows="3"></textarea>
                </div>

                @if ($errors->has('emails'))
                    <p class="text-danger">{{ $errors->first('emails') }}</p>
                @endif

                <p id="mailsCount" class="text-info">Total Mails: <span>0</span></p>
                <div class="mb-3">
                    <div class="d-flex flex-row">
                        <button class="btn btn-block btn-primary ms-3">Send Mails</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@section('script')

<script>

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

$(document).ready(() => {

    const textArea = $("textarea#commaSeperatedTextarea");
    const paragraph = $("p#mailsCount");

    textArea.on('change', () => {
        const value = textArea.val();
        const values = value.split(",");
        paragraph.find("span").text(values.length)
    })
})






// Example usage:
const email = 'example@example.com';
console.log(); // Returns true if the email is valid



</script>

@endsection
