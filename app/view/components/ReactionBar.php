<?php
// Blade Component - app/View/Components/ReactionBar.php
namespace App\View\Components;

use Illuminate\View\Component;

class ReactionBar extends Component
{
    public $reactable;
    public $showTotal;
    
    public function __construct($reactable, $showTotal = true)
    {
        $this->reactable = $reactable;
        $this->showTotal = $showTotal;
    }

    public function render()
    {
        return view('components.reaction-bar');
    }
}
?>

<!-- Blade Template - resources/views/components/reaction-bar.blade.php -->
<div class="reaction-bar" 
     data-reactable-type="{{ get_class($reactable) }}" 
     data-reactable-id="{{ $reactable->id }}">
     
    @php
        $reactions = [
            'like' => '👍',
            'love' => '❤️', 
            'laugh' => '😂',
            'angry' => '😠',
            'sad' => '😢'
        ];
        
        $reactionCounts = $reactable->reaction_counts ?? [];
        $userReaction = $reactable->user_reaction;
    @endphp

    @foreach($reactions as $type => $emoji)
        <button class="reaction-button {{ $userReaction === $type ? 'active' : '' }}" 
                data-type="{{ $type }}"
                data-active="{{ $userReaction === $type ? 'true' : 'false' }}">
            <span class="reaction-emoji">{{ $emoji }}</span>
            <span class="reaction-count">{{ $reactionCounts[$type] ?? 0 }}</span>
        </button>
    @endforeach
    
    @if($showTotal)
        <div class="total-reactions">
            Total: <span class="total-count">{{ $reactable->total_reactions ?? 0 }}</span>
        </div>
    @endif
</div>

<?php
// Usage in your views - resources/views/posts/index.blade.php
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Social Feed</h1>
    
    @foreach($posts as $post)
        <div class="post-card">
            <div class="post-header">
                <div class="post-author">{{ $post->user->name }}</div>
                <div class="post-date">{{ $post->created_at->diffForHumans() }}</div>
            </div>
            
            <div class="post-content">
                {{ $post->content }}
            </div>

            <!-- Use the reusable component -->
            <x-reaction-bar :reactable="$post" />
        </div>
    @endforeach
    
    {{ $posts->links() }}
</div>
@endsection