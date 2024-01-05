<?php

namespace Service;

use Lib\Database\Entity\Product;
use Lib\Database\Entity\VisitedProduct;
use Models\ProductModel;
use Models\VisitedProductModel;

class VisitedProductService extends BaseDatabaseService {
    public function getProductsWithVisitorsForDateRange(string $minDate, string $maxDate): array {
        $visitedProducts = $this->executeQuery("SELECT visit.productId, count(distinct visit.sessionUserGuid) as visitors FROM visitedproduct visit inner join product prod on prod.id = visit.productId where visit.date >= ? and visit.date <= ? group by prod.id", [$minDate, $maxDate], VisitedProduct::class);
        $allProducts = $this->executeQuery("select id, name from product order by name", [], Product::class);
        $productsSold = $this->executeQuery("select item.productId, sum(item.quantity) as totalAmount, count(item.productId) as orderAmount from `order` ord inner join orderitem item on item.orderId = ord.id where ord.createdOn >= ? and ord.createdOn <= ? group by item.productId, ord.userId", [$minDate, $maxDate]);

        $models = array();
        foreach($allProducts as $product) {
            $model = new VisitedProductModel();
            $model->product = ProductModel::convertToModel($product);
            $model->visitors = $this->getVisitorAmountByProductId($product->id, $visitedProducts);
            $model->orderAmount = $this->getOrderAmountByProductId($product->id, $productsSold);
            $model->totalAmount = $this->getTotalAmountSoldByProductId($product->id, $productsSold);
            $model->ratioUniqueOrders = $model->visitors > 0 ? round($model->orderAmount / $model->visitors, 1) * 100 : 0;
            $model->ratioTotalAmount = $model->visitors > 0 ? round($model->totalAmount / $model->visitors, 1) * 100 : 0;

            $models[] = $model;
        }

        return $models;
    }

    private function getVisitorAmountByProductId(int $productId, array $visitedProducts): int {
        return current(array_filter($visitedProducts, fn($visitedProduct) => $visitedProduct->productId == $productId))->visitors ?? 0;
    }

    private function getOrderAmountByProductId(int $productId, array $productOrderData): int {
        return current(array_filter($productOrderData, fn($productOrder) => $productOrder->productId == $productId))->orderAmount ?? 0;
    }

    private function getTotalAmountSoldByProductId(int $productId, array $productOrderData): int {
        return current(array_filter($productOrderData, fn($productOrder) => $productOrder->productId == $productId))->totalAmount ?? 0;
    }
}