CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_orders` (
        `id_order` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11)  NOT NULL,
        `id_plan` int(11)  NULL,
        `id_currency` int(11)  NULL,
        `id_domain` int(11)  NULL,
        `session_id` varchar(255)  NULL,
        `reference` varchar(128)  NULL,
        `sub_type` varchar(128)  NULL,
        `app_domain` varchar(128)  NULL,
        `active` tinyint(1)  DEFAULT 0,
        `activation_date` datetime  NULL,
        `current_billing_start` datetime  NULL,
        `current_billing_end` datetime  NULL,
        `next_invoice` datetime  NULL,
        `last_invoice` datetime  NULL,
        `default_total` decimal(20,2) NULL,
        `recurrent_amount` decimal(20,2) NULL,
        `order_total` decimal(20,2) NULL,
        `cost_price` decimal(20,2) NULL,
        `profit` decimal(20,2) NULL,
        `status` varchar(128)  NULL,
        `authorization_code` varchar(255)  NULL,
        `ip` varchar(255)  NULL,
        `security_message` varchar(255)  NULL,
        `status_message` text  NULL,
        `update_status` varchar(128)  NULL,
        `payload`  text  NULL,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_order`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_invoices` (
        `id_invoice` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11)  NOT NULL,
        `id_order` int(11) NOT NULL,
        `active` tinyint(1)  DEFAULT 1,
        `payment_date` datetime  NULL,
        `billing_start` datetime  NULL,
        `billing_end` datetime  NULL,
        `refunded` tinyint(1) DEFAULT 0,
        `reference` varchar(128)  NULL,
        `access_code` varchar(128)  NULL,
        `payment_url` varchar(128)  NULL,
        `payment_type` varchar(128)  NULL,
        `default_amount` decimal(20,2) NULL,
        `invoice_amount` decimal(20,2) NULL,
        `paid_amount` decimal(20,2) NULL,
        `transaction_id` decimal(20,2) NULL,
        `first_6digits` varchar(255)  NULL,
        `last_4digits` varchar(128)  NULL,
        `issuer` varchar(255)  NULL,
        `signature` varchar(255)  NULL,
        `token` varchar(255)  NULL,
        `ip` varchar(255)  NULL,
        `card_type` varchar(255)  NULL,
        `expiry` varchar(255)  NULL,
        `status` varchar(128)  NULL,
        `status_message` text  NULL,
        `payload`  text  NULL,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_invoice`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_plans` (
        `id_plan` int(11) NOT NULL AUTO_INCREMENT,
        `plan_type` varchar(64) NULL,
        `app_type` varchar(64) NULL,
        `name` varchar(128)  NULL,
        `sub_name` varchar(128)  NULL,
        `plan_code` varchar(128)  NULL,
        `plan_code_id` int(11)  NULL,
        `memory_size` varchar(128)  NULL,
        `disk_space` varchar(128)  NULL,
        `bandwidth` varchar(128)  NULL,
        `price_currency` varchar(128)  NULL,
        `monthly_price` decimal(20,2) NULL,
        `yearly_price` decimal(20,2) NULL,
        `description`  text  NULL,
        `payload`  text  NULL,
        `status`  varchar(64)  NULL,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_plan`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_domains` (
        `id_domain` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `id_reg_address` int(11) NOT NULL,
        `id_admin_address` int(11) NOT NULL,
        `id_tech_address` int(11) NOT NULL,
        `id_billing_address` int(11) NOT NULL,
        `first_years` int(11)  NULL DEFAULT 1,
        `current_years` int(11)  NULL DEFAULT 1,
        `name` varchar(255)  NULL,
        `active` tinyint(1) NOT NULL DEFAULT 0,
        `status` varchar(128) NULL,
        `domain_state` varchar(128) NULL,
        `transfer_code` varchar(255)  NULL,
        `transfer_note` varchar(255)  NULL,
        `client_ip` varchar(64)  NULL,
        `transaction_id` varchar(128)  NULL,
        `cost_price` decimal(20,4)  NULL,
        `price` decimal(20,4)  NULL,
        `paid_amount` decimal(20,4)  NULL,
        `dns1` varchar(255)  NULL,
        `dns2` varchar(255) NULL,
        `dns3` varchar(255) NULL,
        `dns4` varchar(255) NULL,
        `domain_start` datetime NULL,
        `domain_end` datetime NULL,
        `last_cron` datetime NULL,
        `payload`  text  NULL,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_domain`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_currencies` (
        `id_currency` int(11) NOT NULL AUTO_INCREMENT,
        `is_default` tinyint(1)  DEFAULT 0,
        `rate` decimal(20,2) NULL,
        `country_code` varchar(32)  NULL,
        `name` varchar(32)  NULL,
        `description` varchar(255)  NULL,
        `iso_code` varchar(128)  NULL,
        `sign` varchar(64)  NULL,
        `active` tinyint(1)  DEFAULT 1,
        `deleted` tinyint(1)  DEFAULT 0,
        `payload`  text  NULL,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_currency`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_customers` (
        `id_customer` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `customer_code` varchar(128) NULL,
        `customer_id` varchar(32)  NULL,
        `integration` varchar(32)  NULL,
        `active` tinyint(1)  DEFAULT 1,
        `deleted` tinyint(1)  DEFAULT 0,
        `payload`  text  NULL,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_customer`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_logs` (
        `id_log` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11)  DEFAULT 0,
        `log_type` varchar(128) NULL,
        `message` text  NULL,
        `payload`  text  NULL,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_log`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_addresses` (
        `id_address` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `address_type` varchar(128)  DEFAULT 'Registrant',
        `email` varchar(255)  NULL,
        `firstname` varchar(128)  NULL,
        `lastname` varchar(128)  NULL,
        `address` varchar(255)  NULL,
        `address_2` varchar(128)  NULL,
        `city` varchar(128)  NULL,
        `postal_code` varchar(128)  NULL,
        `phone` varchar(128)  NULL,
        `phone_mobile` varchar(128)  NULL,
        `province_or_state` varchar(128)  NULL,
        `id_country` int(11)  NULL,
        `country_code` varchar(16)  NULL,
        `company_name` varchar(128)  NULL,
        `note` varchar(255)  NULL,
        `passport` varchar(255)  NULL,
        `certificate` varchar(255)  NULL,
        `legislation` varchar(255)  NULL,
        `societiesregistry` varchar(255)  NULL,
        `policalpartyregistry` varchar(255)  NULL,
        `other` varchar(255)  NULL,
        `address_name` varchar(255)  NULL,
        `active` tinyint(1)  DEFAULT 1,
        `deleted` tinyint(1)  DEFAULT 0,
        `payload`  text  NULL,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_address`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_countries` (
        `id_country` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(128)  NULL,
        `code` varchar(64)  NULL,
        `iso3` varchar(255)  NULL,
        `numeric_code` varchar(64)  NULL,
        `calling_code` varchar(64)  NULL,
        `capital` varchar(255)  NULL,
        `currency_code` varchar(128)  NULL,
        `currency_name` varchar(128)  NULL,
        `tld` varchar(32)  NULL,
        `flag` varchar(255)  NULL,
        `active` tinyint(1)  DEFAULT 1,
        `deleted` tinyint(1)  DEFAULT 0,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_country`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_domainprices` (
        `id_price` int(11) NOT NULL AUTO_INCREMENT,
        `tld` varchar(128)  NULL,
        `registration` decimal(20,4)  NULL,
        `renewal` decimal(20,4)  NULL,
        `transfer` decimal(20,4)  NULL,
        `restore` decimal(20,4)  NULL,
        `active` tinyint(1)  DEFAULT 1,
        `deleted` tinyint(1)  DEFAULT 0,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_price`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_tickets` (
        `id_ticket` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11)  NULL,
        `reference` varchar(128)  NULL,
        `department` varchar(128)  NULL,
        `email` varchar(255)  NULL,
        `phone` varchar(64)  NULL,
        `fullname` varchar(255)  NULL,
        `subject` varchar(255)  NULL,
        `message` text  NULL,
        `attachment` varchar(255)  NULL,
        `status` varchar(64)  NULL,
        `note` varchar(255)  NULL,
        `replied` tinyint(1)  DEFAULT 0,
        `read` tinyint(1)  DEFAULT 0,
        `deleted` tinyint(1)  DEFAULT 0,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_ticket`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;

       
CREATE TABLE IF NOT EXISTS `PREFIX_aph_hosting_replies` (
        `id_reply` int(11) NOT NULL AUTO_INCREMENT,
        `id_ticket` int(11)  NULL,
        `user_id` int(11)  NULL,
        `source` varchar(128)  NULL,
        `message` text  NULL,
        `reply_attachment` varchar(255)  NULL,
        `status` varchar(64)  NULL,
        `deleted` tinyint(1)  DEFAULT 0,
        `created_at` datetime  NULL,
        `updated_at` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_reply`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;