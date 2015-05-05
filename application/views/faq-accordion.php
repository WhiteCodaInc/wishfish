<link rel="stylesheet" href="<?= base_url() ?>assets/faq/autocomplete/autocomplete.css" type="text/css" />
<!-- Paga title -->
<div class="main-header">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-lg-8">
                <h1>Knowledge Base</h1>
                <p class="tagline">Find answers and help fast</p>
            </div>
            <div class="col-sm-4 col-lg-4">
                <form class="form-search" role="search"> 
                    <input type="text" id="search" class="ui-autocomplete-input form-control input-lg" autocomplete="off" placeholder="Enter search term here." /> 
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Main content -->
<!-- Main content -->
<div class="wrap container" role="document">
    <div class="content row">
        <div class="main col-sm-9" role="main">

            <div class="page-header">
                <h1></h1>
            </div>

            <div  class="page-main">
                <div class="question-detail-list">
                    <h2 id="2existing-customer-questions1" class="faq-section-heading">
                        <?= (isset($isFirst) && $isFirst) ? $category->category_name : '' ?>
                    </h2>
                    <?php if ((isset($isFirst) && $isFirst) || (isset($isSearch) && $isSearch)): ?>
                        <?php $res = (isset($isFirst) && $isFirst) ? $questions : $question; ?>
                        <?php foreach ($res as $value) { ?>
                            <article class="faq clearfix">
                                <h3 id="question-<?= $value->faq_id ?>" class="entry-title">
                                    <span></span>
                                    <a name="<?= $value->faq_id ?>"></a>
                                    <?= $value->question ?>
                                </h3>
                                <div class="faq-content">
                                    <?= $value->answer ?>
                                </div>
                            </article>
                        <?php } ?>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- /.main -->

        <!-- Sidebar -->
        <aside class="sidebar col-sm-3" role="complementary">
            <section class="widget nav_menu-2 widget_nav_menu">
                <div>
                    <h3>Knowledge Base</h3>
                    <ul>
                        <?php foreach ($categories as $value) { ?>
                            <li>
                                <a href="<?= site_url() ?>faq/getQuestions/<?= $value->category_id ?>">
                                    <?= $value->category_name ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </section>
        </aside><!-- /.sidebar -->
    </div><!-- /.content -->
</div><!-- /.wrap -->

<script type="text/javascript">
    $(document).ready(function () {
<?php if (isset($isSearch) && $isSearch): ?>
            setTimeout(function () {
                $('article.faq h3').children('span').trigger('click');
            }, 10);

<?php endif; ?>
    });

    $(function () {
        $("#search").autocomplete({
            source: "<?= site_url() ?>faq/getSearchTerm",
            minLength: 2,
            select: function (event, ui) {
                var getUrl = ui.item.url;
                if (getUrl != '#') {
                    location.href = getUrl;
                }
            },
            html: true,
            open: function (event, ui) {
                $(".ui-autocomplete").css("z-index", 1000);
            }
        });
    });
</script>