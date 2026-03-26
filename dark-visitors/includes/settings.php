<?php

// Registration

function dark_visitors_register_settings() {
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_ACCESS_TOKEN);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_ANALYTICS_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_ENFORCE_ROBOTS_TXT_ENABLED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_SETTINGS_LAST_SAVED);
    register_setting(DARK_VISITORS_SETTINGS_GROUP, DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED);
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
            max-width: 40rem;
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
        
        h1 {
            font-weight: bold !important;
        }

        h2 {
            font-weight: bold;
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

        .premium-feature label {
            vertical-align: revert;
            font-weight: bold;
        }
    </style>
    <div class="wrap">
        <h1 class="fake-header"></h1>
        <div class="container">
            <div class="header-container">
                <img src="<?php echo esc_url(DARK_VISITORS_LOGO_URL); ?>">
                <h1>Known Agents</h1>
                <em>Formerly Dark Visitors</em>
            </div>
            <p>Get realtime visibility into crawlers, scrapers, and AI agents browsing your website. Measure human traffic coming from AI chat and search LLMs like ChatGPT, Claude, and Gemini. Protect sensitive content from unwanted scraping with a robots.txt that stays up to date with the latest bots automatically.</p>
            <div class="button-container">
                <a class="button" href="https://knownagents.com/projects" target="_blank">See Your Hidden Bot Traffic ↗</a>
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
                            <p>In 30 seconds, <a href="https://knownagents.com/sign-up" target="_blank">sign up for free</a> and <a href="https://knownagents.com/projects" target="_blank">create a new project</a>. This gives you access to your website's dashboard.</p>
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
                            <label for="dark_visitors_is_analytics_enabled">Enable Agent & LLM Analytics</label><br>
                            <p>Track the activity of <a href="https://knownagents.com/agents" target="_blank">all known agents</a> crawling your website, and human referrals coming from AI chat and search LLMs like ChatGPT, Claude, and Gemini. Insights can be seen on your <a href="https://knownagents.com/projects" target="_blank">dashboard</a>. You can test this by following the instructions in the <a href="https://knownagents.com/docs/analytics" target="_blank">docs</a>.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <div class="table-header-step-number-label">Step 4:</div>
                            <div class="table-header-step-text-label">Set Up Automatic Robots.txt</div>
                        </th>
                        <td>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_BLOCK_AI_ASSISTANTS_ENABLED, '0') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_block_ai_assistants_enabled">Block AI Assistants</label><br>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_DATA_SCRAPERS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_DATA_SCRAPERS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_BLOCK_AI_DATA_SCRAPERS_ENABLED, '0') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_block_ai_data_scrapers_enabled">Block AI Data Scrapers</label><br>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_SEARCH_CRAWLERS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_AI_SEARCH_CRAWLERS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_BLOCK_AI_SEARCH_CRAWLERS_ENABLED, '0') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_block_ai_search_crawlers_enabled">Block AI Search Crawlers</label><br>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_ARCHIVERS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_ARCHIVERS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_BLOCK_ARCHIVERS_ENABLED, '0') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_block_archivers_enabled">Block Archivers</label><br>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_INTELLIGENCE_GATHERERS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_INTELLIGENCE_GATHERERS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_BLOCK_INTELLIGENCE_GATHERERS_ENABLED, '0') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_block_intelligence_gatherers_enabled">Block Intelligence Gatherers</label><br>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_SCRAPERS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_SCRAPERS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_BLOCK_SCRAPERS_ENABLED, '0') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_block_scrapers_enabled">Block Scrapers</label><br>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_SEO_CRAWLERS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_SEO_CRAWLERS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_BLOCK_SEO_CRAWLERS_ENABLED, '0') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_block_seo_crawlers_enabled">Block SEO Crawlers</label><br>
                            <input
                                type="checkbox"
                                id="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_UNDOCUMENTED_AI_AGENTS_ENABLED); ?>"
                                name="<?php echo esc_attr(DARK_VISITORS_IS_BLOCK_UNDOCUMENTED_AI_AGENTS_ENABLED); ?>"
                                <?php checked(get_option(DARK_VISITORS_IS_BLOCK_UNDOCUMENTED_AI_AGENTS_ENABLED, '0') == '1'); ?>
                                value="1"
                            />
                            <label for="dark_visitors_is_block_undocumented_ai_agents_enabled">Block Undocumented AI Agents</label><br>
                            <p>Protect IP, reduce server cost, and save time by not needing to make manual edits for individual agents. Checking each box will add robots.txt rules to disallow <a href="https://knownagents.com/agents" target="_blank">every agent in that category</a>, updating automatically as new agents are discovered. For more detail, read the <a href="https://knownagents.com/docs/robots-txt" target="_blank">docs</a>.</p>
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
                                <label for="dark_visitors_is_enforce_robots_txt_enabled">Forcefully Block Misbehaving Bots</label><br>
                                <p>Agents that violate your robots.txt rules will receive an HTTP 403 Forbidden response, completely blocking access to your website's content. You'll be able to see these blocked visits on your <a href="https://knownagents.com/projects" target="_blank">dashboard</a>. Make sure any caching you're doing respects the standard Cache-Control HTTP header.</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <div class="table-header-step-number-label">Step 5:</div>
                            <div class="table-header-step-text-label">Review Your Dashboard</div>
                        </th>
                        <td>
                            <p><a href="https://knownagents.com/projects" target="_blank">Open your dashboard</a> to see AI agents and bots visiting your website.</p>
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
