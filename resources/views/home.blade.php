@extends('layouts.app')

@section('content')
<div class="container">
    <div class="hero-section text-center mb-5 glass-card float-animation" style="background: linear-gradient(135deg, rgba(74, 108, 250, 0.2), rgba(138, 43, 226, 0.2)); padding: 3rem; border-radius: 20px;">
        <h1 class="display-4 fw-bold mb-3 glow-text animate__animated animate__fadeInDown">مرحبًا بك في MiniSocial</h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp">شارك أفكارك، تواصل مع الأصدقاء، واستكشف محتوى جديد</p>
        <div class="animate__animated animate__fadeIn">
            <a href="{{ route('register.view') }}" class="neo-btn me-2">انضم إلينا</a>
            <a href="{{ route('login.view') }}" class="neo-btn" style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); border: 1px solid var(--glass-border);">تسجيل الدخول</a>
            <a href="/posts" class="neo-btn me-2 mt-2 mt-md-0">عرض المنشورات</a>
        </div>
    </div>

    <!-- إنشاء منشور جديد -->
    <div class="create-post-container fade-in">
        <div class="post-header">
            <div class="user-avatar glow-animation">م</div>
            <div class="post-info">
                <h6> أحمد</h6>
            </div>
        </div>

        <textarea class="post-input" placeholder="ماذا يدور في ذهنك؟"></textarea>

        <div class="media-preview" id="mediaPreview"></div>

        <div class="media-actions">
            <label for="imageUpload" class="media-btn">
                <i class="bi bi-image"></i> صورة
            </label>
            <label for="videoUpload" class="media-btn">
                <i class="bi bi-camera-video"></i> فيديو
            </label>
            <input type="file" id="imageUpload" accept="image/*" style="display: none;">
            <input type="file" id="videoUpload" accept="video/*" style="display: none;">
        </div>

        <button class="post-submit">نشر</button>
    </div>

    <!-- منشور 1 -->
    <div class="glass-card fade-in">
        <div class="post-header">
            <div class="user-avatar glow-animation">م</div>
            <div class="post-info">
                <h6>محمد أحمد</h6>
                <div class="post-time">
                    <i class="bi bi-globe"></i> منذ 3 ساعات
                </div>
            </div>
            <i class="bi bi-three-dots" style="color: var(--text-muted); cursor: pointer;"></i>
        </div>

        <div class="post-content">
            <p class="post-text">هذا مثال لمنشور. يمكن للمستخدمين الإعجاب والتعليق ومشاركة المنشورات هنا.</p>
            <div class="post-media">
                <img src="https://images.unsplash.com/photo-1579546929662-711aa81148cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="صورة مثال">
            </div>
        </div>

        <div class="post-stats">
            <div class="reactions-count">
                <div class="reactions-icons">
                    <div class="reaction-icon" style="background-color: #1877F2;"></div>
                    <div class="reaction-icon" style="background-color: #F3425F;"></div>
                </div>
                <span>۱۲۳</span>
            </div>
            <div class="comments-count">٤ تعليقات</div>
        </div>

        <div class="post-actions">
            <div class="fb-reaction-container">
                <div class="fb-main-reaction">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <span>إعجاب</span>
                </div>
                <div class="fb-reactions-box">
                    <div class="fb-reaction like" title="إعجاب" data-reaction="like">👍</div>
                    <div class="fb-reaction love" title="حب" data-reaction="love">❤️</div>
                    <div class="fb-reaction haha" title="ضحك" data-reaction="haha">😄</div>
                    <div class="fb-reaction wow" title="دهشة" data-reaction="wow">😯</div>
                    <div class="fb-reaction sad" title="حزن" data-reaction="sad">😢</div>
                    <div class="fb-reaction angry" title="غضب" data-reaction="angry">😡</div>
                </div>
            </div>

            <div class="action-btn" onclick="toggleComments(this)">
                <i class="bi bi-chat"></i>
                <span>تعليق</span>
            </div>

            <div class="action-btn">
                <i class="bi bi-share"></i>
                <span>مشاركة</span>
            </div>
        </div>

        <div class="comments-section">
            <div class="comment">
                <div class="comment-avatar">س</div>
                <div class="comment-content">
                    <div class="comment-author">سارة</div>
                    <div class="comment-text">منشور رائع! 👏</div>
                    <div class="comment-actions">
                        <span class="comment-action" onclick="likeComment(this)">
                            <i class="bi bi-hand-thumbs-up"></i> إعجاب
                        </span>
                        <span class="comment-action">رد</span>
                        <span class="comment-action">منذ ساعة</span>
                        <span class="comment-action">3</span>
                    </div>
                </div>
            </div>

            <div class="add-comment">
                <input type="text" class="comment-input" placeholder="اكتب تعليقًا...">
                <button class="comment-submit">نشر</button>
            </div>
        </div>
    </div>

    <!-- منشور 2 -->
    <div class="glass-card fade-in">
        <div class="post-header">
            <div class="user-avatar glow-animation">س</div>
            <div class="post-info">
                <h6>سارة محمد</h6>
                <div class="post-time">
                    <i class="bi bi-globe"></i> منذ 6 ساعات
                </div>
            </div>
            <i class="bi bi-three-dots" style="color: var(--text-muted); cursor: pointer;"></i>
        </div>

        <div class="post-content">
            <p class="post-text">تجربة الفيديو في المنشورات الجديدة رائعة! يمكنني الآن مشاركة اللحظات المهمة بشكل أفضل.</p>
            <div class="post-media">
                <video controls>
                    <source src="https://assets.mixkit.co/videos/preview/mixkit-tree-with-yellow-flowers-1173-large.mp4" type="video/mp4">
                    متصفحك لا يدعم تشغيل الفيديو
                </video>
            </div>
        </div>

        <div class="post-stats">
            <div class="reactions-count">
                <div class="reactions-icons">
                    <div class="reaction-icon" style="background-color: #F7B928;"></div>
                </div>
                <span>٤٥</span>
            </div>
            <div class="comments-count">۲ تعليقات</div>
        </div>

        <div class="post-actions">
            <div class="fb-reaction-container">
                <div class="fb-main-reaction">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <span>إعجاب</span>
                </div>
                <div class="fb-reactions-box">
                    <div class="fb-reaction like" title="إعجاب" data-reaction="like">👍</div>
                    <div class="fb-reaction love" title="حب" data-reaction="love">❤️</div>
                    <div class="fb-reaction haha" title="ضحك" data-reaction="haha">😄</div>
                    <div class="fb-reaction wow" title="دهشة" data-reaction="wow">😯</div>
                    <div class="fb-reaction sad" title="حزن" data-reaction="sad">😢</div>
                    <div class="fb-reaction angry" title="غضب" data-reaction="angry">😡</div>
                </div>
            </div>

            <div class="action-btn" onclick="toggleComments(this)">
                <i class="bi bi-chat"></i>
                <span>تعليق</span>
            </div>

            <div class="action-btn">
                <i class="bi bi-share"></i>
                <span>مشاركة</span>
            </div>
        </div>

        <div class="comments-section">
            <div class="comment">
                <div class="comment-avatar">ع</div>
                <div class="comment-content">
                    <div class="comment-author">علي</div>
                    <div class="comment-text">الفيديو رائع! أتمنى أن أرى المزيد من هذه الميزة.</div>
                    <div class="comment-actions">
                        <span class="comment-action" onclick="likeComment(this)">
                            <i class="bi bi-hand-thumbs-up"></i> إعجاب
                        </span>
                        <span class="comment-action">رد</span>
                        <span class="comment-action">منذ ٣ ساعات</span>
                        <span class="comment-action">7</span>
                    </div>
                </div>
            </div>

            <div class="add-comment">
                <input type="text" class="comment-input" placeholder="اكتب تعليقًا...">
                <button class="comment-submit">نشر</button>
            </div>
        </div>
    </div>

    <!-- منشور 3 -->
    <div class="glass-card fade-in">
        <div class="post-header">
            <div class="user-avatar glow-animation">ع</div>
            <div class="post-info">
                <h6>علي حسين</h6>
                <div class="post-time">
                    <i class="bi bi-globe"></i> منذ يوم واحد
                </div>
            </div>
            <i class="bi bi-three-dots" style="color: var(--text-muted); cursor: pointer;"></i>
        </div>

        <div class="post-content">
            <p class="post-text">تجربة التصميم الزجاجي رائعة! أشعر وكأنني أستخدم تطبيقًا حديثًا يعمل بتقنيات متطورة.</p>
        </div>

        <div class="post-stats">
            <div class="reactions-count">
                <div class="reactions-icons">
                    <div class="reaction-icon" style="background-color: #1877F2;"></div>
                    <div class="reaction-icon" style="background-color: #F7B928;"></div>
                    <div class="reaction-icon" style="background-color: #F3425F;"></div>
                </div>
                <span>۲۱۸</span>
            </div>
            <div class="comments-count">۱۲ تعليق</div>
        </div>

        <div class="post-actions">
            <div class="fb-reaction-container">
                <div class="fb-main-reaction">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <span>إعجاب</span>
                </div>
                <div class="fb-reactions-box">
                    <div class="fb-reaction like" title="إعجاب" data-reaction="like">👍</div>
                    <div class="fb-reaction love" title="حب" data-reaction="love">❤️</div>
                    <div class="fb-reaction haha" title="ضحك" data-reaction="haha">😄</div>
                    <div class="fb-reaction wow" title="دهشة" data-reaction="wow">😯</div>
                    <div class="fb-reaction sad" title="حزن" data-reaction="sad">😢</div>
                    <div class="fb-reaction angry" title="غضب" data-reaction="angry">😡</div>
                </div>
            </div>

            <div class="action-btn" onclick="toggleComments(this)">
                <i class="bi bi-chat"></i>
                <span>تعليق</span>
            </div>

            <div class="action-btn">
                <i class="bi bi-share"></i>
                <span>مشاركة</span>
            </div>
        </div>

        <div class="comments-section">
            <div class="comment">
                <div class="comment-avatar">م</div>
                <div class="comment-content">
                    <div class="comment-author">محمد</div>
                    <div class="comment-text">أوافقك الرأي! التصميم الزجاجي يعطي شعورًا بالعمق والحداثة.</div>
                    <div class="comment-actions">
                        <span class="comment-action" onclick="likeComment(this)">
                            <i class="bi bi-hand-thumbs-up"></i> إعجاب
                        </span>
                        <span class="comment-action">رد</span>
                        <span class="comment-action">منذ ٥ ساعات</span>
                        <span class="comment-action">5</span>
                    </div>
                </div>
            </div>

            <div class="comment">
                <div class="comment-avatar">ل</div>
                <div class="comment-content">
                    <div class="comment-author">ليلى</div>
                    <div class="comment-text">الجسيمات في الخلفية جميلة جدًا! ✨</div>
                    <div class="comment-actions">
                        <span class="comment-action comment-liked" onclick="likeComment(this)">
                            <i class="bi bi-hand-thumbs-up-fill"></i> أعجبك
                        </span>
                        <span class="comment-action">رد</span>
                        <span class="comment-action">منذ ٣ ساعات</span>
                        <span class="comment-action">8</span>
                    </div>
                </div>
            </div>

            <div class="add-comment">
                <input type="text" class="comment-input" placeholder="اكتب تعليقًا...">
                <button class="comment-submit">نشر</button>
            </div>
        </div>
    </div>
</div>
@endsection
