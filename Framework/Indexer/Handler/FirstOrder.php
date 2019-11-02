<?php
namespace RWCandy\Core\Framework\Indexer\Handler;
use Magento\Customer\Model\ResourceModel\Customer\Collection as CC;
use Magento\Framework\App\ResourceConnection\SourceProviderInterface as ISourceProvider;
use Magento\Framework\Indexer\HandlerInterface as IHandler;
// 2019-11-02
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class FirstOrder implements IHandler {
	/**
	 * 2019-11-02
	 * @override
	 * @see \Magento\Framework\Indexer\HandlerInterface::prepareSql()
	 * @used-by \Magento\Framework\Indexer\Action\Base::createResultCollection()
	 * @param ISourceProvider|CC $cc
	 * @param string $alias «e»
	 * @param array $fieldInfo
	 *	{
	 *		"dataType": "date",
	 *		"filters": [],
	 *		"handler": {},
	 *		"name": "first_date",
	 *		"origin": "first_date",
	 *		"type": "filterable"
	 *	}
	 */
	function prepareSql(ISourceProvider $cc, $alias, $fieldInfo) {
		$cc->getSelect()->columns(['first_date' => df_select()
			->from(['so' => df_table('sales_order')], [])
			->columns(['first_date' => new \Zend_Db_Expr('MIN(so.created_at)')])
			->where('e.email = so.customer_email')
		]);
	}
}