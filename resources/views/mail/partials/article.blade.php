<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="center">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>
                                    <a class="article" href="{{ url('/article/' . $article->slug) }}">
                                        <div class="index">
                                            <span>{{ $article->id }}</span>
                                            <small><i class="fas fa-clock"></i> {{ $article->read_time }}min read</small>
                                        </div>
                                        <div class="info">
                                            <h2>{{ $article->shortTitle }}</h2>
                                            <p>{{ $article->description }}</p>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
