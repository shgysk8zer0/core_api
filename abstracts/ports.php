<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Abstracts
 * @version 1.0.0
 * @copyright 2015, Chris Zuber
 * @license http://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3 (GPL-3.0)
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace shgysk8zer0\Core_API\Abstracts;

abstract class Ports
{
	const FTP_DATA   = 20;
	const FTP        = 21;
	const SSH        = 22;
	const SFTP       = 22;
	const TELNET     = 23;
	const WHOIS      = 43;
	const DNS        = 53;
	const GOPHER     = 70;
	const HTTP       = 80;
	const POP3       = 110;
	const IDENT      = 113;
	const IMAP       = 143;
	const IRC        = 194;
	const IMAP_3     = 220;
	const HTTPS      = 443;
	const SMTPS      = 465;
	const SMTP       = 587;
	const FLASH      = 843;
	const RSYNC      = 873;
	const SAMBA      = 901;
	const SHAREPOINT = 987;
	const FTPS_DATA  = 989;
	const FTPS       = 990;
	const NAS        = 991;
	const TELNETS    = 993;
	const IRCS       = 994;
	const POP3S      = 995;
	const IMAPS      = 993;
	const MYSQL      = 3306;
}
