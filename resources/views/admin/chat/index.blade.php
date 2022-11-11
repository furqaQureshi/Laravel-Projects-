@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Chat</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">

                <div class="customercarechats">
                    <div class="cutomerlist">
                        <ul>
                            @foreach($idRecord as $id)
                                <li class="{{$id['unique_id'] == $activeId ? 'active' : ''}}" >
									<a href="/chats?id={{$id['unique_id']}}">{{$id['name']}}<span>{{$id['unique_id']}}</span></a>
									<span class="badge badge-danger new-chat-count" data-id="{{$id['unique_id']}}"></span>
								</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="chatBubble">
                        <div class="bubblesDv" id="chat-history">

                            

                            <span id="marker"></span>
                        </div>
                        <div class="noNetworkError">No Network or Disconnected</div>
                        <div class="footerDv">
                            <div class="typeDv"><textarea></textarea></div>
                            <button class="btn btn-primary" data-active-id="{{$activeId}}">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('style')
        <link rel="stylesheet" href="{{asset('assets/css/chat.css')}}">
    @endpush

    @push('scripts')
        <script src="{{asset('assets/js/chat.js')}}"></script>
        <script type="text/javascript">
            const admin_name = '{{$admin->name}}';
            $(document).ready(function () {
				fetchLatestChat("{{$activeId}}");
                setInterval(function(){
                    fetchLatestChat("{{$activeId}}");
                }, 10000); // Every 5 second
            });
        </script>
    @endpush
@endsection
