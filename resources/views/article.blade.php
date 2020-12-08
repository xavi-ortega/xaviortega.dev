@extends('layouts.master')

@section('title', $article->title)

@section('page-styles')
<link rel="stylesheet" href="/css/article.css">
@endsection

@section('body')
<article>
    {!! $article->content !!}

    <footer class="mt-5">
        <div class="comments">
            <h3>Opinions</h3>

            <div class="alert alert-danger" style="display: none" id="error-feedback"></div>

            <form id="comment-form" action="#">
                <input type="hidden" name="article_id" value="{{ $article->id }}">

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="author" class="form-control" placeholder="Name (optional)">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="feedback">
                            <label>Reaction:</label>

                            <div class="likes ml-3">
                                <i class="fas fa-thumbs-up" id="thumbs-up"></i>
                                {{ $article->likes }}
                            </div>

                            <div class="dislikes ml-3">
                                <i class="fas fa-thumbs-down" id="thumbs-down"></i>
                                {{ $article->dislikes }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <textarea name="body" placeholder="Leave your opinion" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group clearfix mb-5">
                    <button type="submit" class="btn btn-outline-secondary float-right">Comment</button>
                </div>
            </form>
            @if($article->comments->count() > 0)
            @foreach($article->comments as $comment)
            @unless($comment->hidden)
            <div class="comment mb-3">
                <div class="comment-header mb-3">
                    <div class="comment-metadata">
                        <span>{{ $comment->author ?? 'Annonymous' }}</span> &nbsp;•&nbsp; {{ $comment->created_at->format('M j') }}
                    </div>

                    @if($comment->pleased)
                    <i class="fas fa-thumbs-up text-primary" title="{{ $comment->author ?? 'Annonyous' }} loved the article" id="thumbs-up"></i>
                    @else
                    <i class="fas fa-thumbs-down text-danger" title="{{ $comment->author ?? 'Annonyous' }} wasn't pleased by article" id="thumbs-down"></i>
                    @endif

                </div>

                <div class="comment-body">
                    {{ $comment->body }}
                </div>
            </div>
            @endunless
            @endforeach
            @endif
        </div>
    </footer>
</article>
@endsection

@section('page-scripts')
<script src="/js/article.js"></script>
@endsection
