@extends('Template')
@extends('admin/navbar')
@section('Title')
    List Feedback
@endsection

@section('Content')
<main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
    @php
        Use App\Model\Feedback;
    @endphp
    <h3>Customer Feedback</h3>
    <table id='listFeedback' class='table-striped display'>
        <thead>
            <td>Nama User</td>
            <td>Message</td>
            <td>Tanggal Feedback</td>
        </thead>
        <tbody>
            @foreach (Feedback::all() as $item)
                <tr>
                    @if ($item->id_user == "Guest")
                    <td>Guest</td>
                    @else
                    <td>{{DB::table("user")->where('id_user',$item->id_user)->value('nama_user')}}</td>
                    @endif
                    <td>{{$item->message}}</td>
                    <td>{{$item->tgl_feedback}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
<script>
    $(document).ready(function(){
        $("#listFeedback").DataTable();
    })
</script>
@endsection
