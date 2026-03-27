<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WIRED — Title Aggregator</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --black: #0a0a0a; --white: #f5f5f0; --mid: #888; --rule: #d0d0c8; }
        body { background: var(--white); color: var(--black); font-family: 'DM Mono', monospace; min-height: 100vh; }
        header { border-bottom: 3px solid var(--black); padding: 2rem 3rem 1.5rem; display: flex; align-items: baseline; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .masthead { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 900; letter-spacing: -0.02em; line-height: 1; }
        .masthead span { font-weight: 700; font-style: italic; font-size: 0.55em; letter-spacing: 0.08em; vertical-align: middle; margin-left: 0.5rem; color: var(--mid); }
        .meta-bar { font-size: 0.7rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--mid); text-align: right; line-height: 1.7; }
        .meta-bar a { color: var(--black); text-decoration: none; border-bottom: 1px solid var(--black); padding-bottom: 1px; transition: opacity .2s; }
        .meta-bar a:hover { opacity: .5; }
        .ticker { background: var(--black); color: var(--white); font-size: 0.65rem; letter-spacing: 0.15em; text-transform: uppercase; padding: 0.45rem 3rem; display: flex; justify-content: space-between; align-items: center; }
        main { max-width: 900px; margin: 0 auto; padding: 3rem 3rem 5rem; }
        .section-label { font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--mid); margin-bottom: 2rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--rule); }
        .article-list { list-style: none; }
        .article-item { display: grid; grid-template-columns: 6rem 1fr; gap: 0 2rem; padding: 1.25rem 0; border-bottom: 1px solid var(--rule); align-items: baseline; }
        .article-date { font-size: 0.65rem; color: var(--mid); letter-spacing: 0.05em; white-space: nowrap; padding-top: 0.15rem; }
        .article-title { font-family: 'Playfair Display', serif; font-size: clamp(0.95rem, 2vw, 1.1rem); font-weight: 700; line-height: 1.35; }
        .article-title a { color: var(--black); text-decoration: none; border-bottom: 1px solid transparent; transition: border-color .2s; }
        .article-title a:hover { border-bottom-color: var(--black); }
        .empty { text-align: center; padding: 5rem 2rem; color: var(--mid); font-size: 0.85rem; }
        .empty strong { display: block; font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--black); margin-bottom: 0.5rem; }
        .flash { background: var(--black); color: var(--white); font-size: 0.7rem; letter-spacing: 0.1em; padding: 0.75rem 3rem; text-align: center; }
        footer { border-top: 3px solid var(--black); padding: 1.25rem 3rem; display: flex; justify-content: space-between; font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--mid); }
    </style>
</head>
<body>
    @if(session('message'))
        <div class="flash">{{ session('message') }}</div>
    @endif
    <header>
        <div class="masthead">WIRED <span>Headlines</span></div>
        <div class="meta-bar">
            Since Jan 1, 2022<br>
            {{ count($articles) }} articles indexed<br>
            <a href="{{ route('refresh') }}">↻ Refresh feed</a>
        </div>
    </header>
    <div class="ticker">
        <span>Source: wired.com</span>
        <span>Anti-chronological · Latest first</span>
        <span>Updated: {{ now()->format('d M Y · H:i') }}</span>
    </div>
    <main>
        <p class="section-label">All articles from January 1, 2022 onwards — newest first</p>
        @if(count($articles) > 0)
            <ul class="article-list">
                @foreach($articles as $article)
                    <li class="article-item">
                        <span class="article-date">{{ $article['date_str'] }}</span>
                        <h2 class="article-title">
                            <a href="{{ $article['url'] }}" target="_blank" rel="noopener">{{ $article['title'] }}</a>
                        </h2>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty">
                <strong>No articles found</strong>
                Could not fetch the feed. Try refreshing.
            </div>
        @endif
    </main>
    <footer>
        <span>Wired Title Aggregator</span>
        <span>wired.com · RSS Feed</span>
    </footer>
</body>
</html>