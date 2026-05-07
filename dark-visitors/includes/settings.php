<?php

// Registration

function dark_visitors_register_settings() {
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_ACCESS_TOKEN);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_ANALYTICS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_ENFORCE_ROBOTS_TXT_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_SETTINGS_LAST_SAVED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_AI_DATA_PROVIDERS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_AI_DATA_SCRAPERS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_AI_SEARCH_CRAWLERS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_ARCHIVERS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_INTELLIGENCE_GATHERERS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_SCRAPERS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_SEO_CRAWLERS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_UNDOCUMENTED_AI_AGENTS_ENABLED);
}

add_action('admin_init', 'dark_visitors_register_settings');

// Menu Item

function dark_visitors_menu() {
    add_menu_page(
        // Page title
        'Known Agents',
        // Menu title
        'Known Agents',
        // Capability required to access the menu
        'manage_options',
        // Menu slug
        'dark-visitors',
        // Callback function to display the page
        'dark_visitors_page',
         // Menu icon
        'data:image/svg+xml;base64,' . base64_encode(file_get_contents(DARK_VISITORS_LOGO_PATH))
    );
}

add_action('admin_menu', 'dark_visitors_menu');

// Settings Page

function dark_visitors_page() {
    $is_robots_txt_enforcement_disallowed = dark_visitors_get_user_is_robots_txt_enforcement_disallowed();

    ?>
    <style>
        .fake-header {
            display: none;
        }

        .container {
            max-width: 50rem;
            margin-left: auto;
            margin-right: auto;
        }

        .header-container {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .header-container img {
            height: 2rem;
        }

        .header-container h1 {
            padding: 0;
        }

        .button-container {
            margin-top: 1rem;
            text-align: center;
        }
        
        h1, h2 {
            font-weight: bold !important;
        }

        hr {
            border: none;
            height: 1px;
            background-color: rgba(0, 0, 0, 0.2);
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        input[type="text"] {
            width: 100%;
        }

        input[type="checkbox"]:disabled {
            border-color: revert;
            opacity: revert;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        table, th, td {
            border: 1px solid rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 1rem;
        }

        th {
            background-color: rgba(0, 0, 0, 0.05);
        }

        td p {
            color: rgba(0, 0, 0, 0.5);
        }

        td p:first-child {
            margin-top: 0;
        }

        td p:last-child {
            margin-bottom: 0;
        }

        .table-header-step-number-label {
            margin-bottom: 0.5rem;
        }
        
        .table-header-step-text-label {
            font-weight: normal;
        }

        .premium-feature {
            background-color: rgba(52, 199, 89, 0.05);
            border: 1px solid #35C759;
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .premium-feature .title {
            color: #35C759;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .premium-feature .description {
            font-style: italic;
            margin-bottom: 1rem;
        }

        td label {
            font-weight: bold;
        }

        .premium-feature label {
            vertical-align: revert;
        }

        .category-td {
            padding: 0;
        }

        .category-td > p {
            margin: 0;
            padding-top: 1rem;
            padding-right: 1rem;
            padding-bottom: 0;
            padding-left: 1rem;
        }

        .category-td > .premium-feature {
            padding: 1rem;
            margin: 1rem;
        }

        .category-table {
            border: none;
        }

        .category-table td {
            border: none;
            padding-top: 1rem;
            padding-right: 0;
            padding-bottom: 0;
            padding-left: 1rem;
            vertical-align: top;
            width: 50%;
        }

        .category-table td:last-child {
            padding-right: 1rem;
        }

        .category-table p {
            margin-top: 0.25rem;
        }

    </style>
    <div class="wrap">
        <h1 class="fake-header"></h1>
        <div class="container">
            <div class="header-container">
                <img src="<?php echo esc_url(DARK_VISITORS_LOGO_URL); ?>">
                <h1>Known Agents</h1>
            </div>
            <p>Get realtime visibility into crawlers, scrapers, and AI agents browsing your website. Measure human conversions from AI chat and search platforms like ChatGPT, Claude, and Gemini. Protect your content and reduce server cost by serving a robots.txt that updates continuously.</p>
            <div class="button-container">
                <a class="button" href="https://knownagents.com/projects" target="_blank">Open Your Dashboard ↗</a>
            </div>
            <h2>Configuration</h2>
            <form method="post" action="options.php" class="dark-visitors-form">
                <?php settings_fields(DARK_VISITORS_SETTINGS_GROUP); ?>
                <table>
                    <tr>
                        <th scope="row">
                            <div class="table-header-step-number-label">Step 1:</div>
                            <div class="table-header-step-text-label">Get Started</div>
                        </th>
                        <td>
                            <p>To see your dashboard, <a href="https://knownagents.com/sign-up" target="_blank">sign up</a> and <a href="https://knownagents.com/projects" target="_blank">create a new project</a>. This is free and takes less than 30 seconds.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <div class="table-header-step-number-label">Step 2:</div>
                            <div class="table-header-step-text-label">Connect Your Project</div>
                        </th>
                        <td>
                            <input type="text"
                                placeholder="Paste your project's access token here"
                                id="<?php echo esc_attr(DARK_VISITORS_ACCESS_TOKEN); ?>" 
                                name="<?php echo esc_attr(DARK_VISITORS_ACCESS_TOKEN); ?>" 
                                value="<?php echo esc_attr(get_option(DARK_VISITORS_ACCESS_TOKEN, '')); ?>"
                            />
                            <p>Copy and paste your access token from your project's settings page.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <div class="table-header-step-number-label">Step 3:</div>
                            <div class="table-header-step-text-label">Set Up Agent & LLM Analytics</div>
                        </th>
                        <td>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_ANALYTICS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_ANALYTICS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_ANALYTICS_ENABLED, '1') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_analytics_enabled">Enable Agent & LLM Analytics</label>
                            <p>Track the activity of every AI agent and bot crawling your website, plus citations and human referrals from AI platforms like ChatGPT, Claude, and Gemini. You can test this by following the steps in the <a href="https://knownagents.com/docs/analytics/wordpress" target="_blank">docs</a>. Realtime activity can be seen on <a href="https://knownagents.com/projects" target="_blank">your dashboard</a>.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <div class="table-header-step-number-label">Step 4:</div>
                            <div class="table-header-step-text-label">Set Up Automatic Robots.txt</div>
                        </th>
                        <td class="category-td">
                            <p>Protect your content and reduce server cost. Checking each box will add robots.txt rules that disallow every agent in that category, and automatically update them as new agents are discovered. Visit the <a href="https://knownagents.com/agents" target="_blank">Agents Database</a> to learn more about the categories and tradeoffs.</p>
                            <table class="category-table">
                                <tr>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_DATA_SCRAPERS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_DATA_SCRAPERS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_AI_DATA_SCRAPERS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_ai_data_scrapers_enabled">Block AI Data Scrapers</label> <a href="https://knownagents.com/agents?agent_type_url_slug=ai-data-scraper" target="_blank">↗</a>
                                        <p class="category-description">Downloads website content to include in datasets used for training AI models such as LLMs</p>
                                    </td>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_DATA_PROVIDERS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_DATA_PROVIDERS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_AI_DATA_PROVIDERS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_ai_data_providers_enabled">Block AI Data Providers</label> <a href="https://knownagents.com/agents?agent_type_url_slug=ai-data-provider" target="_blank">↗</a>
                                        <p class="category-description">Crawls websites to supply structured content to AI systems as a third-party service</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_ai_assistants_enabled">Block AI Assistants</label> <a href="https://knownagents.com/agents?agent_type_url_slug=ai-assistant" target="_blank">↗</a>
                                        <p class="category-description">Fetches website content in response to a user prompt, to include in an AI-generated answer</p>
                                    </td>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_SEARCH_CRAWLERS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_SEARCH_CRAWLERS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_AI_SEARCH_CRAWLERS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_ai_search_crawlers_enabled">Block AI Search Crawlers</label> <a href="https://knownagents.com/agents?agent_type_url_slug=ai-search-crawler" target="_blank">↗</a>
                                        <p class="category-description">Indexes website content to possibly include as citations in AI-powered search results</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_UNDOCUMENTED_AI_AGENTS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_UNDOCUMENTED_AI_AGENTS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_UNDOCUMENTED_AI_AGENTS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_undocumented_ai_agents_enabled">Block Undocumented AI Agents</label> <a href="https://knownagents.com/agents?agent_type_url_slug=undocumented-ai-agent" target="_blank">↗</a>
                                        <p class="category-description">Crawls websites without disclosing its purpose, collecting data for an unknown AI use case</p>
                                    </td>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_SCRAPERS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_SCRAPERS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_SCRAPERS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_scrapers_enabled">Block Scrapers</label> <a href="https://knownagents.com/agents?agent_type_url_slug=scraper" target="_blank">↗</a>
                                        <p class="category-description">Extracts large amounts of web data, often without explicit website permission</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_SEO_CRAWLERS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_SEO_CRAWLERS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_SEO_CRAWLERS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_seo_crawlers_enabled">Block SEO Crawlers</label> <a href="https://knownagents.com/agents?agent_type_url_slug=seo-crawler" target="_blank">↗</a>
                                        <p class="category-description">Analyzes website structure and content to identify SEO improvement opportunities</p>
                                    </td>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_ARCHIVERS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_ARCHIVERS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_ARCHIVERS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_archivers_enabled">Block Archivers</label> <a href="https://knownagents.com/agents?agent_type_url_slug=archiver" target="_blank">↗</a>
                                        <p class="category-description">Captures and stores historical website snapshots for long-term digital preservation</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_INTELLIGENCE_GATHERERS_ENABLED); ?>"
                                            name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_INTELLIGENCE_GATHERERS_ENABLED); ?>"
                                            <?php checked(get_option(DARK_VISITORS_IS_BLOCK_INTELLIGENCE_GATHERERS_ENABLED, '0') == '1'); ?>
                                            value="1"
                                        />
                                        <label for="dark_visitors_is_block_intelligence_gatherers_enabled">Block Intelligence Gatherers</label> <a href="https://knownagents.com/agents?agent_type_url_slug=intelligence-gatherer" target="_blank">↗</a>
                                        <p class="category-description">Analyzes web content for brand safety, competitive insights, and ad targeting</p>
                                    </td>
                                    <td></td>
                                </tr>
                            </table>
                            <div class="premium-feature">
                                <div class="title">Premium Feature</div>
                                <?php if ($is_robots_txt_enforcement_disallowed) { ?>
                                    <p class="description"><a href="https://knownagents.com/pricing" target="_blank">Upgrade your plan</a> to unlock this feature. If you recently upgraded, click "Save Changes" to sync your account.</p>
                                <?php } ?>
                                <input
                                    type="checkbox"
                                    id="<?php echo esc_attr(DARK_VISITORS_IS_ENFORCE_ROBOTS_TXT_ENABLED); ?>"
                                    name="<?php echo esc_attr(DARK_VISITORS_IS_ENFORCE_ROBOTS_TXT_ENABLED); ?>"
                                    <?php checked(get_option(DARK_VISITORS_IS_ENFORCE_ROBOTS_TXT_ENABLED, '0') == '1' && !$is_robots_txt_enforcement_disallowed); ?>
                                    <?php disabled($is_robots_txt_enforcement_disallowed); ?>
                                    value="1"
                                />
                                <label for="dark_visitors_is_enforce_robots_txt_enabled">Forcefully Block Misbehaving Bots</label>
                                <p>Agents that ignore your robots.txt rules will receive an HTTP 403 Forbidden response, blocking access to your website's content. Make sure any caching you're doing respects the standard Cache-Control HTTP header.</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <div class="table-header-step-number-label">Step 5:</div>
                            <div class="table-header-step-text-label">Review Your Dashboard</div>
                        </th>
                        <td>
                            <p><a href="https://knownagents.com/projects" target="_blank">Open your dashboard</a> to see AI agents and bots visiting your website in real time.</p>
                        </td>
                    </tr>
                </table>
                <input
                    type="hidden" 
                    name="<?php echo esc_attr(DARK_VISITORS_SETTINGS_LAST_SAVED); ?>" 
                    value="<?php echo esc_attr(time()); ?>" 
                />
                <?php submit_button(); ?>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector(".dark-visitors-form");
            const accessTokenField = document.getElementById("<?php echo esc_js(DARK_VISITORS_ACCESS_TOKEN); ?>");
            form.addEventListener("submit", function(event) {
                if (accessTokenField.value.trim() == "") {
                    alert("Please enter your access token. Get one in under 30 seconds.");
                    event.preventDefault();
                    accessTokenField.focus();
                    return false;
                }
            });
        });
    </script>
    <?php
}
