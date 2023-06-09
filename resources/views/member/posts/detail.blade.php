<div class="modal fade" id="post-detail-modal" style="padding-right: 0;overflow-y: hidden">
    <div class="modal-dialog" style="height: 100%;" >
        <div class="modal-content" id="content-post-detail">
            <!-- Modal body -->
            <div class="modal-body p-0">
                <div>
                    <button type="button" class="close pt-1 pr-1" data-dismiss="modal">×</button>
                </div>
                <div class="row merged" style="height: 100vh; overflow-y: scroll">
                    <div class="col-lg-9">
                        <div class="pop-image">
                            <div class="pop-item">
                                <figure id="post-image"></figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="commentbar">
                            <div class="user m-0">
                                <div class="d-flex">
                                    <figure><img style="height: 40px; width: 40px; border-radius: 20px" id="user-image" src="" alt=""></figure>
                                    <div>
                                        <strong class="mt-1 pl-2"><a href="#" id="user-name" class="user-name"></a></strong>
                                        <p id="post-time" class="mb-0 pl-2"></p>
                                    </div>
                                </div>

                                <div class="user-information">

                                    <div>
                                        <p style="color:black; font-weight: 600; font-size: 18px" id="post-title"></p>
                                    </div>
                                </div>
                                {{--                        <a href="index.html#" title="Follow" data-ripple="">Follow</a>--}}
                            </div>
                            <div class="stat-tools m-0">
                                <div class="box">
                                    <div class="Like"><a class="Like__link"><i class="icofont-like"></i>
                                            Like</a>
                                        <div class="Emojis">
                                            <div class="Emoji Emoji--like">
                                    <span class="reactions-like">
                                        <div class="icon icon--like "></div>
                                    </span>
                                            </div>
                                            <div class="Emoji Emoji--love">
                                    <span class="reactions-heart">
                                        <div class="icon icon--heart"></div>
                                    </span>
                                            </div>
                                            <div class="Emoji Emoji--haha">
                                    <span class="reactions-haha">
                                        <div class="icon icon--haha"></div>
                                    </span>
                                            </div>
                                            <div class="Emoji Emoji--wow">
                                    <span class="reactions-wow">
                                        <div class="icon icon--wow"></div>
                                    </span>
                                            </div>
                                            <div class="Emoji Emoji--sad">
                                    <span class="reactions-sad">
                                        <div class="icon icon--sad"></div>
                                    </span>
                                            </div>
                                            <div class="Emoji Emoji--angry">
                                    <span class="reactions-angry">
                                        <div class="icon icon--angry"></div>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="Emojis">
                                        <div class="Emoji Emoji--like">
                                    <span class="reactions-like">
                                        <div class="icon icon--like "></div>
                                    </span>
                                        </div>
                                        <div class="Emoji Emoji--love">
                                    <span class="reactions-heart">
                                        <div class="icon icon--heart"></div>
                                    </span>
                                        </div>
                                        <div class="Emoji Emoji--haha">
                                    <span class="reactions-haha">
                                        <div class="icon icon--haha"></div>
                                    </span>
                                        </div>
                                        <div class="Emoji Emoji--wow">
                                    <span class="reactions-wow">
                                        <div class="icon icon--wow"></div>
                                    </span>
                                        </div>
                                        <div class="Emoji Emoji--sad">
                                    <span class="reactions-sad">
                                        <div class="icon icon--sad"></div>
                                    </span>
                                        </div>
                                        <div class="Emoji Emoji--angry">
                                    <span class="reactions-angry">
                                        <div class="icon icon--angry"></div>
                                    </span>
                                        </div>
                                    </div>
                                </div>
{{--                                <a title="" href="index.html#" class="share-to"><i--}}
{{--                                        class="icofont-share-alt"></i> Share</a>--}}
                            </div>

                            <div id="post-comments-section">

                            </div>
                            <div class="auto-load text-center">
                                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                                        <path fill="#000" d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                                        </path>
                                        </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
