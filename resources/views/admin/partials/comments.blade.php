<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.33/sweetalert2.js" integrity="sha512-Wik6VzWpliJYZMjeHqoM4Hured+Z/mIvR9mTsIBHLFkqMYYchKpGP1ZFUro6XsPo4W2msCkSVqaw4/oDde+cmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.33/sweetalert2.css" integrity="sha512-e+TwvhjDvKqpzQLJ7zmtqqz+5jF9uIOa+5s1cishBRfmapg7mqcEzEl44ufb04BXOsEbccjHK9V0IVukORmO8w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@foreach($comments as $comment)
    <li style="list-style: none">
        <div class="d-flex mt-3 content-comment">
            <figure><img style="width: 50px; height: 50px; border-radius: 30px" alt="" src="{{ $comment->user->avatar }}"></figure>
                <p style="margin-top: 5px; margin-left: 10px">{{ $comment->user->name }}</p>
{{--            <a href="{{ route('admin.destroycomment',$comment->id) }}">--}}
{{--                <i style="width: 20px; height: 20px; margin-left:100px; margin-top: 10px;" class="fa-solid fa-trash-can"></i>--}}
{{--            </a>--}}
            <div class="delete-button cursor-pointer" data-id=" {{ $comment->id }}">

                <i style="width: 20px; height: 20px; margin-left:100px; margin-top: 10px;" class="fa-solid fa-trash-can"></i>
            </div>
        </div>
        <p style="margin-left: 80px; margin-top: -30px">{{ $comment->content }}</p>
        <script>
            $('.delete-button').on('click', function (e) {
                // const id = $(this).attr('data-id');

                confirmAlert('Bạn có chắc chắn xóa không?').then(function (res) {
                    if (res.isConfirmed) {
                        axios.get('{{ route('admin.destroycomment',$comment->id) }}/')
                            .then(function (response) {

                                successAlert(response.message).then(function (res) {
                                    window.location.reload();
                                })
                            }).catch(function (error) {
                            console.log(error);
                        })
                    }
                })
            })

        </script>
@endforeach



