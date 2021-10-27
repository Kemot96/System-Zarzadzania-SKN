@extends('layouts.adminLayout')

@section('content')


    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edytuj email') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('emails.update', $email->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row">
                            <label for="message"
                                   class="col-md-3 col-form-label text-md-right">{{ __('Treść') }}</label>

                            <div class="col-md-7">
                                    <textarea rows="5" id="message" type="text"
                                              class="form-control @error('message') is-invalid @enderror" name="message"
                                              required autocomplete="off" autofocus>{{ $email->message }}</textarea>

                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if($email->type == "spending_plan_reminder" || $email->type == "report_reminder" ||
$email->type == "action_plan_reminder" || $email->type == "new_academic_year_acceptance_of_members" || $email->type == "spending_plan_demand_reminder")
                            <br>
                            <div><b>Poniżej można ustawić daty wysyłania corocznych wiadomości (maksymalnie dwie)</b>
                            </div><br>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="day">{{ __('Dzień') }}</label>
                                    <select id="day" class="form-control @error('day') is-invalid @enderror" name="day">
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{$i}}"
                                                    @if($email->day == $i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>

                                    @error('day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="month">{{ __('Miesiąc') }}</label>


                                    <select id="month" class="form-control @error('month') is-invalid @enderror"
                                            name="month">
                                        <option value="1" @if($email->month == 1) selected="selected" @endif>Styczeń
                                        </option>
                                        <option value="2" @if($email->month == 2) selected="selected" @endif>Luty
                                        </option>
                                        <option value="3" @if($email->month == 3) selected="selected" @endif>Marzec
                                        </option>
                                        <option value="4" @if($email->month == 4) selected="selected" @endif>Kwiecień
                                        </option>
                                        <option value="5" @if($email->month == 5) selected="selected" @endif>Maj
                                        </option>
                                        <option value="6" @if($email->month == 6) selected="selected" @endif>Czerwiec
                                        </option>
                                        <option value="7" @if($email->month == 7) selected="selected" @endif>Lipiec
                                        </option>
                                        <option value="8" @if($email->month == 8) selected="selected" @endif>Sierpień
                                        </option>
                                        <option value="9" @if($email->month == 9) selected="selected" @endif>Wrzesień
                                        </option>
                                        <option value="10" @if($email->month == 10) selected="selected" @endif>
                                            Październik
                                        </option>
                                        <option value="11" @if($email->month == 11) selected="selected" @endif>
                                            Listopad
                                        </option>
                                        <option value="12" @if($email->month == 12) selected="selected" @endif>
                                            Grudzień
                                        </option>
                                    </select>

                                    @error('month')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label style="visibility: hidden" for="send_on_schedule">{{ __('Trick') }}</label>
                                    <div class="form-check">
                                        <input type="hidden" name="send_on_schedule" value="0"/>
                                        <input class="form-check-input" type="checkbox" id="send_on_schedule"
                                               name="send_on_schedule" value="1"
                                               @if($email->send_on_schedule == 1) checked @endif>
                                        <label class="form-check-label" for="send_on_schedule">
                                            Wysyłaj corocznie
                                        </label>
                                    </div>
                                </div>

                            </div>



                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="day2">{{ __('Dzień') }}</label>
                                    <select id="day2" class="form-control @error('day2') is-invalid @enderror"
                                            name="day2">
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{$i}}"
                                                    @if($email->day2 == $i) selected="selected" @endif>{{$i}}</option>
                                        @endfor
                                    </select>

                                    @error('day2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="month2">{{ __('Miesiąc') }}</label>


                                    <select id="month2" class="form-control @error('month2') is-invalid @enderror"
                                            name="month2">
                                        <option value="1" @if($email->month2 == 1) selected="selected" @endif>Styczeń
                                        </option>
                                        <option value="2" @if($email->month2 == 2) selected="selected" @endif>Luty
                                        </option>
                                        <option value="3" @if($email->month2 == 3) selected="selected" @endif>Marzec
                                        </option>
                                        <option value="4" @if($email->month2 == 4) selected="selected" @endif>Kwiecień
                                        </option>
                                        <option value="5" @if($email->month2 == 5) selected="selected" @endif>Maj
                                        </option>
                                        <option value="6" @if($email->month2 == 6) selected="selected" @endif>Czerwiec
                                        </option>
                                        <option value="7" @if($email->month2 == 7) selected="selected" @endif>Lipiec
                                        </option>
                                        <option value="8" @if($email->month2 == 8) selected="selected" @endif>Sierpień
                                        </option>
                                        <option value="9" @if($email->month2 == 9) selected="selected" @endif>Wrzesień
                                        </option>
                                        <option value="10" @if($email->month2 == 10) selected="selected" @endif>
                                            Październik
                                        </option>
                                        <option value="11" @if($email->month2 == 11) selected="selected" @endif>
                                            Listopad
                                        </option>
                                        <option value="12" @if($email->month2 == 12) selected="selected" @endif>
                                            Grudzień
                                        </option>
                                    </select>

                                    @error('month2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label style="visibility: hidden" for="send_on_schedule">{{ __('Trick') }}</label>
                                    <div class="form-check">
                                        <input type="hidden" name="send_on_schedule2" value="0"/>
                                        <input class="form-check-input" type="checkbox" id="send_on_schedule2"
                                               name="send_on_schedule2" value="1"
                                               @if($email->send_on_schedule2 == 1) checked @endif>
                                        <label class="form-check-label" for="send_on_schedule2">
                                            Wysyłaj corocznie
                                        </label>
                                    </div>
                                </div>

                            </div>
                        @endif
                        <div class="form-group row justify-content-center">
                            <div class="form-check">
                                <input type="hidden" name="enable_sending" value="0"/>
                                <input class="form-check-input" type="checkbox" id="enable_sending"
                                       name="enable_sending" value="1" @if($email->enable_sending == 1) checked @endif>
                                <label class="form-check-label" for="enable_sending">
                                    Włącz wysyłanie tej wiadomości
                                </label>
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edytuj email') }}
                                </button>
                                <a href="{{ route('emails.index')}}" class="btn btn-danger">Anuluj</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        if ($('#send_on_schedule').is(':checked') === false) {
            $('#day').prop('disabled', true);
            $('#month').prop('disabled', true);
        } else {
            $('#day').prop('disabled', false);
            $('#month').prop('disabled', false);
        }

        if ($('#send_on_schedule2').is(':checked') === false) {
            $('#day2').prop('disabled', true);
            $('#month2').prop('disabled', true);
        } else {
            $('#day2').prop('disabled', false);
            $('#month2').prop('disabled', false);
        }

        $('#send_on_schedule').change(function () {
            if ($('#send_on_schedule').is(':checked') === false) {
                $('#day').prop('disabled', true);
                $('#month').prop('disabled', true);
            } else {
                $('#day').prop('disabled', false);
                $('#month').prop('disabled', false);
            }
        });

        $('#send_on_schedule2').change(function () {
            if ($('#send_on_schedule2').is(':checked') === false) {
                $('#day2').prop('disabled', true);
                $('#month2').prop('disabled', true);
            } else {
                $('#day2').prop('disabled', false);
                $('#month2').prop('disabled', false);
            }
        });

    </script>

@endsection
