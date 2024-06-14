@extends('layouts.app')

@section('title', 'Rooms')

@section('content')
    <h1>Reservation PASTALIA</h1>

    @if (isset($message))
        <div class="alert alert-{{ $alertType }}" role="alert">
            {!! $message !!}
        </div>
    @endif

    <br>
    <h3>Booking Table form</h3>
    <form name="myForm" action="{{ route('book-room') }}" method="post" onsubmit="return validateForm()">
        @csrf
        <input type="hidden" name="bookRoom">
        <div class="mb-3">
            <label for="Date" class="form-label">Date:</label>
            <input type="text" name="datePicked" id="datepicker" class="form-control">
        </div>
        <div class="mb-3">
            <label for="Start time" class="form-label">Start time:</label>
            <div class="d-flex">
                <select name="startTimeHour" class="form-select me-1">
                    @for ($i = 0; $i < 24; $i++)
                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                    @endfor
                </select>
                :
                <select name="startTimeMinute" class="form-select ms-1 me-1">
                    @for ($i = 0; $i < 60; $i += 5)
                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                    @endfor
                </select>
                :
                <select name="startTimeSecond" class="form-select ms-1">
                    @for ($i = 0; $i < 60; $i++)
                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="End time" class="form-label">End time:</label>
            <div class="d-flex">
                <select name="endTimeHour" class="form-select me-1">
                    @for ($i = 0; $i < 24; $i++)
                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                    @endfor
                </select>
                :
                <select name="endTimeMinute" class="form-select ms-1 me-1">
                    @for ($i = 0; $i < 60; $i += 5)
                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                    @endfor
                </select>
                :
                <select name="endTimeSecond" class="form-select ms-1">
                    @for ($i = 0; $i < 60; $i++)
                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="Capacity" class="form-label">Capacity:</label>
            <select name="capacity" class="form-select">
                @for ($i = 2; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }} pers.</option>
                @endfor
            </select>
        </div>
        <input type="submit" value="Book room" class="btn btn-primary">
    </form>

    <br><br><br>
    <div align="center">Created by <a href="http://www.PASTALIA.com">PASTALIA</a>.</div>

    <br><br><br><br><br><br>
@endsection

@push('scripts')
    <script>
        function validateForm() {
            var capacity = document.forms["myForm"]["capacity"].value;
            if (capacity == "") {
                alert("Capacity must be filled out");
                return false;
            }
            var startTime = document.forms["myForm"]["startTimeHour"].value + ':' + document.forms["myForm"]["startTimeMinute"].value + ':' + document.forms["myForm"]["startTimeSecond"].value;
            var endTime = document.forms["myForm"]["endTimeHour"].value + ':' + document.forms["myForm"]["endTimeMinute"].value + ':' + document.forms["myForm"]["endTimeSecond"].value;
            var isValid1 = /^([0-1]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/.test(startTime);
            var isValid2 = /^([0-1]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/.test(endTime);
            if (!isValid1 || !isValid2) {
                alert("Time must be in the format HH:MM:SS");
                return false;
            }
            if (parseInt(startTime.replace(/:/g, '')) >= parseInt(endTime.replace(/:/g, ''))) {
                alert("End time must be after start time");
                return false;
            }
            if (startTime == "") {
                alert("Start time must be filled out");
                return false;
            }
            if (endTime == "") {
                alert("End time must be filled out");
                return false;
            }
            var datePicked = document.forms["myForm"]["datePicked"].value;
            var isValidDate = /^\d{2}\/\d{2}\/\d{4}$/.test(datePicked);
            if (!isValidDate) {
                alert("Date must be in the format DD/MM/YYYY");
                return false;
            }
        }
    </script>
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
@endpush
