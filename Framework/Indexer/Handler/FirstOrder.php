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
	 * The current solution (via `LEFT JOIN`) takes just 3 seconds on `bin/magento indexer:reindex customer_grid`.
	 * The previous colution (via a subquery) took almost 7 minutes on `bin/magento indexer:reindex customer_grid`:
	 * https://github.com/royalwholesalecandy/core/blob/1.0.0/Framework/Indexer/Handler/FirstOrder.php#L27-L31
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
		$cc->getSelect()->joinLeft(
			['so' => df_select()
				->from(df_table('sales_order'), [])
				->columns(['email' => 'customer_email', 'first_date' => new \Zend_Db_Expr('MIN(created_at)')])
				->group('email')
			]
			,'e.email = so.email'
			,['first_date']
		);
	}
}